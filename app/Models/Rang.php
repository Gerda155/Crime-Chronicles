<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rang extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'rangs';
    
    protected $fillable = [
        'name',
        'min_score',
        'max_score',
        'status'
    ];
    
    protected $attributes = [
        'status' => 'active'
    ];
    
    /**
     * Проверка пересечения с другими рангами
     */
    public static function hasOverlap($minScore, $maxScore, $excludeId = null)
    {
        $query = self::query();
        
        // Если max_score не указан, считаем что это бесконечность
        if (is_null($maxScore)) {
            $query->where(function($q) use ($minScore) {
                $q->where('min_score', '<=', $minScore)
                  ->where(function($sub) use ($minScore) {
                      $sub->where('max_score', '>=', $minScore)
                           ->orWhereNull('max_score');
                  });
            });
        } else {
            $query->where(function($q) use ($minScore, $maxScore) {
                // Проверка на пересечение диапазонов
                $q->whereBetween('min_score', [$minScore, $maxScore])
                  ->orWhereBetween('max_score', [$minScore, $maxScore])
                  ->orWhere(function($sub) use ($minScore, $maxScore) {
                      $sub->where('min_score', '<=', $minScore)
                           ->where(function($q2) use ($maxScore) {  // <-- ИСПРАВЛЕНО: $maxScore вместо $min
                               $q2->where('max_score', '>=', $maxScore)  // <-- ИСПРАВЛЕНО: $maxScore
                                   ->orWhereNull('max_score');
                           });
                  });
            });
        }
        
        // Исключаем текущий ранг при обновлении
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }
    
    /**
     * Получить ранг по количеству очков
     */
    public static function getByScore($score)
    {
        if (!$score && $score !== 0) {
            return null;
        }
        
        return self::where('status', 'active')
            ->where('min_score', '<=', $score)
            ->where(function($query) use ($score) {
                $query->where('max_score', '>=', $score)
                      ->orWhereNull('max_score');
            })
            ->first();
    }
    
    /**
     * Проверка корректности диапазона
     */
    public static function isValidRange($minScore, $maxScore)
    {
        // Минимальное значение не может быть отрицательным
        if ($minScore < 0) {
            return false;
        }
        
        // Если указан максимальный балл, он должен быть больше минимального
        if (!is_null($maxScore) && $maxScore <= $minScore) {
            return false;
        }
        
        return true;
    }
}
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

    public static function hasOverlap($minScore, $maxScore, $excludeId = null)
    {
        $query = self::query();

        if (is_null($maxScore)) {
            $query->where(function ($q) use ($minScore) {
                $q->where('min_score', '<=', $minScore)
                    ->where(function ($sub) use ($minScore) {
                        $sub->where('max_score', '>=', $minScore)
                            ->orWhereNull('max_score');
                    });
            });
        } else {
            $query->where(function ($q) use ($minScore, $maxScore) {
                $q->whereBetween('min_score', [$minScore, $maxScore])
                    ->orWhereBetween('max_score', [$minScore, $maxScore])
                    ->orWhere(function ($sub) use ($minScore, $maxScore) {
                        $sub->where('min_score', '<=', $minScore)
                            ->where(function ($q2) use ($maxScore) {
                                $q2->where('max_score', '>=', $maxScore)
                                    ->orWhereNull('max_score');
                            });
                    });
            });
        }

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    public static function getByScore($score)
    {
        if (!$score && $score !== 0) {
            return null;
        }

        return self::where('status', 'active')
            ->where('min_score', '<=', $score)
            ->where(function ($query) use ($score) {
                $query->where('max_score', '>=', $score)
                    ->orWhereNull('max_score');
            })
            ->first();
    }

    public static function isValidRange($minScore, $maxScore)
    {
        if ($minScore < 0) {
            return false;
        }

        if (!is_null($maxScore) && $maxScore <= $minScore) {
            return false;
        }

        return true;
    }
}

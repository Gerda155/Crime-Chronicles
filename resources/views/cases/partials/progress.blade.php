<div id="scoreDisplay" style="font-weight: bold; margin-bottom: 10px;">
    Punkti: {{ $progress->score ?? 0 }}
</div>

<div class="progress mb-3">
    <div
        class="progress-bar bg-info"
        role="progressbar"
        style="width: <?php echo isset($progressPercent) ? $progressPercent : 0; ?>%;">
        
        <?php echo isset($progressPercent) ? round($progressPercent) : 0; ?>%
    </div>
</div>
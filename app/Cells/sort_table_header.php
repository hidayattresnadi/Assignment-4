<a href="<?= $params->getSortUrl($tableField, $baseUrl) ?>"
    class="text-white fw-bold text-decoration-none">
    <?= $tableTitleHeader  ?>
    <?= $params->isSortedBy($tableField) ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↓' ?>
</a>
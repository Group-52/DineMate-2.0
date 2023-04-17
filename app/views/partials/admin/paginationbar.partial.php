<!-- Pagination row -->
<?php
//limit of pages
$lim = 5;
$pbef = $currentPage - $lim;
$paft = $currentPage + $lim;
$pbef = $pbef < 1 ? 1 : $pbef;
$paft = $paft > $totalPages ? $totalPages : $paft;

?>

<div class="d-flex justify-content-center pagination">
    <?php if ($totalPages > 1) : ?>
        <nav>
            <div>
                <?php if($currentPage >1 + $lim): ?>
                <span class="page-item">
                    <a class="page-link" href="?page=<?= $currentPage - $lim; ?>"><</a>
                </span>
                <?php endif; ?>

                <!--Previous button-->
                <?php if ($currentPage != 1) : ?>
                    <span class="page-item">
                                <a class="page-link page-move" href="?page=<?=$currentPage - 1; ?>">Previous</a>
                        </span>
                <?php endif; ?>
                <!-- Page numbers-->
                <?php for ($i = $pbef; $i <= $paft; $i++) : ?>
                    <span class="page-item <?php if ($currentPage == $i) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?=$i; ?>"><?=$i; ?></a>
                        </span>
                <?php endfor; ?>
                <!-- Next button-->
                <?php if ($currentPage != $totalPages) : ?>
                    <span class="page-item">
                          <a class="page-link page-move" href="?page=<?=$currentPage + 1; ?>"> Next </a>
                        </span>
                <?php endif; ?>

                <?php if($currentPage < $totalPages - $lim): ?>
                <span class="page-item">
                    <a class="page-link" href="?page=<?= $currentPage + $lim; ?>">></a>
                </span>
                <?php endif; ?>

            </div>
        </nav>
    <?php endif; ?>
</div>
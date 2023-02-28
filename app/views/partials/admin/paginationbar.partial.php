<!-- Pagination row -->

<div class="d-flex justify-content-center pagination">
    <?php if ($totalPages > 1) : ?>
        <nav>
            <div>
                <!--Previous button-->

                <?php if ($currentPage != 1) : ?>
                    <span class="page-item">
                                <a class="page-link page-move" href="?page=<?php echo $currentPage - 1; ?>">Previous</a>
                        </span>
                <?php endif; ?>
                <!-- Page numbers-->
                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <span class="page-item <?php if ($currentPage == $i) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </span>
                <?php endfor; ?>
                <!-- Next button-->
                <?php if ($currentPage != $totalPages) : ?>
                    <span class="page-item">
                          <a class="page-link page-move" href="?page=<?php echo $currentPage + 1; ?>"> Next </a>
                        </span>
                <?php endif; ?>

            </div>
        </nav>
    <?php endif; ?>
</div>
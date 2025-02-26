<?php
include 'includes/header.php';
include 'fetch-added-visitor.php';
?>

<body class="bg-light">
    <div class="d-flex">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php';
        include 'edit-official-modal.php' ?>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            <div class="container mt-4">

                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert-container">
                        <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show"
                            role="alert">
                            <?php
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                            unset($_SESSION['message_type']);
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mt-4">
                    <h3>List of Visitors</h3>
                    <div class="d-flex justify-content-between mb-3">
                        <input type="text" id="search-input" class="form-control w-25" placeholder="Search by name"
                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    </div>
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Name</th>
                                <th>Sex</th>
                                <th>Age</th>
                                <th>Static Code</th>
                                <th>type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="account-table">
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <?php echo $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']; ?>
                                    </td>
                                    <td><?php echo $row['sex_name']; ?></td>
                                    <td><?php echo $row['age']; ?></td>
                                    <td><?php echo $row['static_code']; ?></td>
                                    <td><?php echo $row['type']; ?></td>
                                    <td>
                                        <div class="d-flex gap-2 align-items-center justify-content-center">
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#editModal" data-id="<?php echo $row['id']; ?>"
                                                data-type="<?php echo $row['type'] ?>"
                                                data-firstname="<?php echo $row['first_name'] ?>"
                                                data-middlename="<?php echo $row['middle_name'] ?>"
                                                data-lastname="<?php echo $row['last_name'] ?>"
                                                data-email="<?php echo $row['email'] ?>"
                                                data-sex="<?php echo $row['sex_id'] ?>"
                                                data-age="<?php echo $row['age'] ?>">
                                                EDIT
                                            </button>
                                            <form action="process/delete-official-logic.php" method="POST" class="d-inline">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">DELETE</button>
                                            </form>
                                            <!-- to be finish by tomorrow kasi antok na ko :)) -->
                                            <form action="" method="POST"> 
                                                <input type="hidden" name="static_code" value="<?php echo $row['static_code']; ?>">
                                                <button type="submit" class="btn btn-sm btn-secondary">GET QR</button>
                                            </form>
                                            <!-- end -->
                                        </div>
                                    </td>

                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <nav aria-label="Page navigation">
                        <ul class="pagination" id="pagination">
                            <?php
                            $pagesToShow = 3;

                            $startPage = max(1, $page - (($page - 1) % $pagesToShow));
                            $endPage = min($totalPages, $startPage + $pagesToShow - 1);

                            // Display "Previous" button
                            if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                                </li>
                            <?php endif; ?>

                            <!-- Display the range of pages dynamically -->
                            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Show ellipsis if there are more pages -->
                            <?php if ($endPage < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $endPage + 1; ?>">...</a>
                                </li>
                            <?php endif; ?>

                            <!-- Display "Next" button -->
                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <p>Page <?php echo $page; ?> of <?php echo $totalPages; ?></p>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
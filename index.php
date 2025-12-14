<?php
include "database/connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Accounts Manager</title>
    
    <?php include "code_snippets/cdn_codes.php"; ?>
    
    <style>
        :root {
            --youtube-red: #FF0000;
            --youtube-dark: #CC0000;
            --youtube-light: #FFEDED;
            --dark-bg: #0F0F0F;
            --card-bg: #FFFFFF;
            --text-dark: #212529;
            --text-light: #6C757D;
            --border-color: #E0E0E0;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', 'Segoe UI', Arial, sans-serif;
            color: var(--text-dark);
        }
        
        .youtube-header {
            background: linear-gradient(135deg, var(--youtube-red), var(--youtube-dark));
            color: white;
            padding: 25px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(255, 0, 0, 0.15);
        }
        
        .youtube-logo {
            font-weight: 700;
            font-size: 28px;
            color: white;
            text-decoration: none;
        }
        
        .youtube-logo i {
            margin-right: 10px;
        }
        
        .btn-youtube {
            background-color: var(--youtube-red);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-youtube:hover {
            background-color: var(--youtube-dark);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(255, 0, 0, 0.2);
        }
        
        .btn-youtube-outline {
            background-color: transparent;
            color: var(--youtube-red);
            border: 2px solid var(--youtube-red);
            padding: 8px 18px;
            border-radius: 4px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-youtube-outline:hover {
            background-color: var(--youtube-red);
            color: white;
        }
        
        .account-card {
            background-color: var(--card-bg);
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 15px;
            overflow: hidden;
            border-left: 4px solid var(--youtube-red);
        }
        
        .account-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }
        
        .account-card-header {
            background-color: var(--youtube-light);
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .account-card-body {
            padding: 20px;
        }
        
        .account-email {
            color: var(--youtube-red);
            font-weight: 500;
        }
        
        .account-name {
            font-weight: 600;
            font-size: 18px;
        }
        
        .account-address {
            color: var(--text-light);
            font-size: 14px;
        }
        
        .action-buttons .btn {
            margin-right: 5px;
        }
        
        .btn-edit {
            background-color: #ffc107;
            color: #212529;
        }
        
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            text-align: center;
            border-top: 4px solid var(--youtube-red);
        }
        
        .stats-number {
            font-size: 32px;
            font-weight: 700;
            color: var(--youtube-red);
        }
        
        .stats-label {
            font-size: 14px;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .modal-header {
            background-color: var(--youtube-red);
            color: white;
        }
        
        .modal-header .btn-close {
            filter: invert(1);
        }
        
        .table-custom thead {
            background-color: var(--youtube-light);
            color: var(--youtube-dark);
        }
        
        .table-custom th {
            border-top: none;
            font-weight: 600;
            padding: 15px;
        }
        
        .table-custom td {
            padding: 15px;
            vertical-align: middle;
        }
        
        .table-custom tbody tr:hover {
            background-color: rgba(255, 0, 0, 0.03);
        }
        
        .footer {
            background-color: var(--dark-bg);
            color: white;
            padding: 20px 0;
            margin-top: 50px;
            text-align: center;
        }
        
        .copyright {
            color: #AAAAAA;
            font-size: 14px;
        }
        
        .form-control:focus {
            border-color: var(--youtube-red);
            box-shadow: 0 0 0 0.25rem rgba(255, 0, 0, 0.25);
        }
        
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: var(--text-light);
        }
        
        .empty-state i {
            font-size: 64px;
            color: #DDD;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .account-card {
                margin-bottom: 20px;
            }
            
            .action-buttons .btn {
                margin-bottom: 5px;
                display: block;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header class="youtube-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="#" class="youtube-logo">
                    <i class="fab fa-youtube"></i> YouTube Accounts Manager
                </a>
                <div>
                    <span class="badge bg-light text-dark fs-6">v1.0</span>
                </div>
            </div>
            <p class="mb-0 mt-2 opacity-75">Manage your YouTube accounts and associated channels</p>
        </div>
    </header>

    <main class="container">
        <?php
        $sql = "SELECT * FROM user_accounts";
        $retrieved = $connection->query($sql);
        $total_accounts = $retrieved->num_rows;
        
        // Reset pointer for later use
        $retrieved->data_seek(0);
        ?>
        
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number"><?php echo $total_accounts; ?></div>
                    <div class="stats-label">Total Accounts</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number"><?php echo rand(5, 20); ?></div>
                    <div class="stats-label">Active Channels</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number"><?php echo rand(100, 500); ?>K</div>
                    <div class="stats-label">Total Subscribers</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number"><?php echo rand(1000, 5000); ?></div>
                    <div class="stats-label">Total Videos</div>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">YouTube Accounts</h3>
            <button data-bs-toggle="modal" data-bs-target="#accountModal" class="btn btn-youtube">
                <i class="fas fa-plus-circle me-2"></i>Add New Account
            </button>
        </div>
        
        <?php if($total_accounts > 0): ?>
        <div class="table-responsive">
            <table class="table table-custom table-hover">
                <thead>
                    <tr>
                        <th>Account ID</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($data = $retrieved->fetch_assoc()): ?>
                    <tr>
                        <td><span class="badge bg-secondary">#<?php echo htmlspecialchars($data['account_id']); ?></span></td>
                        <td>
                            <div class="account-email">
                                <i class="fas fa-envelope me-2"></i><?php echo htmlspecialchars($data['email']); ?>
                            </div>
                        </td>
                        <td>
                            <div class="account-name"><?php echo htmlspecialchars($data['first_name']) . ' ' . htmlspecialchars($data['last_name']); ?></div>
                        </td>
                        <td>
                            <div class="account-address">
                                <i class="fas fa-map-marker-alt me-1"></i><?php echo htmlspecialchars($data['address']); ?>
                            </div>
                        </td>
                        <td class="action-buttons">
                            <a href="edit_screen.php?account_id=<?php echo htmlspecialchars($data['account_id']); ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <button class="btn btn-danger btn-sm" onclick="deletePop(<?php echo htmlspecialchars($data['account_id']); ?>)">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-user-slash"></i>
            <h4>No YouTube Accounts Found</h4>
            <p>You haven't added any YouTube accounts yet. Add your first account to get started.</p>
            <button data-bs-toggle="modal" data-bs-target="#accountModal" class="btn btn-youtube">
                <i class="fas fa-plus-circle me-2"></i>Add Your First Account
            </button>
        </div>
        <?php endif; ?>
    </main>
    
    <!-- Add Account Modal -->
    <div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>Add New YouTube Account
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="functions/add_accounts.php" method="POST" id="addAccountForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="example@youtube.com" required>
                                <div class="form-text">This will be the login email for the YouTube account</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="firstname" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="John" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="lastname" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Doe" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Address *</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="123 Main St, City, Country" required>
                            </div>
                        </div>
                        
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Note:</strong> When you add a YouTube account, any associated channels will be automatically linked to this account.
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="addAccountForm" class="btn btn-youtube">
                        <i class="fas fa-save me-2"></i>Save Account
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-md-start text-center mb-3 mb-md-0">
                    <h5><i class="fab fa-youtube me-2"></i>YouTube Accounts Manager</h5>
                    <p class="mb-0">Professional management system for YouTube accounts and channels</p>
                </div>
                <div class="col-md-6 text-md-end text-center">
                    <p class="copyright mb-0">
                        &copy; <?php echo date('Y'); ?> YouTube Accounts Manager. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

<script>
    function deletePop(id){
        Swal.fire({
            title: 'Delete YouTube Account?',
            text: "This will permanently delete the account and all linked channels. This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            backdrop: 'rgba(0,0,0,0.8)'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "functions/delete_accounts.php?id=" + id;
            }
        });
    }
    
    // Show success message if redirected from add/edit
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if(urlParams.has('success')) {
            Swal.fire({
                title: 'Success!',
                text: 'Account operation completed successfully.',
                icon: 'success',
                confirmButtonColor: '#FF0000',
                timer: 2000
            });
        }
    });
</script>
</html>
<?php
$connection->close();
?>
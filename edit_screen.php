<!-- TAGAMA, JHON DARYL A. -->

<?php
include "database/connection.php";

if(!isset($_GET['account_id']) || empty($_GET['account_id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['account_id'];
$sql = "SELECT * FROM user_accounts WHERE account_id = $id";

$retrieved = $connection->query($sql);

if($retrieved->num_rows == 0) {
    header("Location: index.php?error=not_found");
    exit();
}

$data = $retrieved->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit YouTube Account</title>
    
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
            background: linear-gradient(135deg, #f8f9fa 0%, #f0f0f0 100%);
            font-family: 'Roboto', 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            padding-top: 20px;
            padding-bottom: 20px;
        }
        
        .edit-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .edit-header {
            background: linear-gradient(135deg, var(--youtube-red), var(--youtube-dark));
            color: white;
            padding: 25px 30px;
            border-radius: 10px 10px 0 0;
            box-shadow: 0 4px 12px rgba(255, 0, 0, 0.15);
        }
        
        .edit-card {
            background-color: white;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }
        
        .edit-form {
            padding: 30px;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 8px;
        }
        
        .form-control:focus {
            border-color: var(--youtube-red);
            box-shadow: 0 0 0 0.25rem rgba(255, 0, 0, 0.25);
        }
        
        .btn-youtube {
            background-color: var(--youtube-red);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: 500;
            transition: all 0.3s;
            width: 100%;
        }
        
        .btn-youtube:hover {
            background-color: var(--youtube-dark);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(255, 0, 0, 0.2);
        }
        
        .btn-secondary {
            width: 100%;
            padding: 12px 25px;
        }
        
        .account-preview {
            background-color: var(--youtube-light);
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            border-left: 4px solid var(--youtube-red);
        }
        
        .preview-label {
            font-weight: 600;
            color: var(--youtube-dark);
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .preview-value {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 15px;
        }
        
        .back-link {
            color: var(--youtube-red);
            text-decoration: none;
            font-weight: 500;
            display: inline-block;
            margin-bottom: 20px;
        }
        
        .back-link:hover {
            color: var(--youtube-dark);
            text-decoration: underline;
        }
        
        .account-id-badge {
            background-color: var(--youtube-dark);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <a href="index.php" class="back-link">
            <i class="fas fa-arrow-left me-2"></i>Back to Accounts
        </a>
        
        <div class="edit-card">
            <div class="edit-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1"><i class="fas fa-edit me-2"></i>Edit YouTube Account</h2>
                        <p class="mb-0 opacity-75">Update account information and save changes</p>
                    </div>
                    <div class="account-id-badge">
                        Account #<?php echo htmlspecialchars($data['account_id']); ?>
                    </div>
                </div>
            </div>
            
            <div class="edit-form">
                <form action="functions/edit_accounts.php" method="POST" id="editAccountForm">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['account_id']); ?>">
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" name="email" class="form-control" id="email" 
                                   value="<?php echo htmlspecialchars($data['email']); ?>" required>
                            <div class="form-text">The login email for this YouTube account</div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label for="firstname" class="form-label">First Name *</label>
                            <input type="text" name="firstname" class="form-control" id="firstname" 
                                   value="<?php echo htmlspecialchars($data['first_name']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="lastname" class="form-label">Last Name *</label>
                            <input type="text" name="lastname" class="form-control" id="lastname" 
                                   value="<?php echo htmlspecialchars($data['last_name']); ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label for="address" class="form-label">Address *</label>
                            <input type="text" name="address" class="form-control" id="address" 
                                   value="<?php echo htmlspecialchars($data['address']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="account-preview">
                        <div class="preview-label">Current Account Details</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="preview-value">
                                    <i class="fas fa-user me-2"></i>
                                    <?php echo htmlspecialchars($data['first_name']) . ' ' . htmlspecialchars($data['last_name']); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="preview-value">
                                    <i class="fas fa-envelope me-2"></i>
                                    <?php echo htmlspecialchars($data['email']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <a href="index.php" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button type="submit" class="btn-youtube">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="text-center">
            <p class="text-muted">
                <i class="fas fa-info-circle me-2"></i>
                Changes will be applied immediately after saving.
            </p>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <script>
        document.getElementById('editAccountForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const firstname = document.getElementById('firstname').value;
            const lastname = document.getElementById('lastname').value;
            const address = document.getElementById('address').value;
            
            if(!email || !firstname || !lastname || !address) {
                e.preventDefault();
                Swal.fire({
                    title: 'Missing Information',
                    text: 'Please fill in all required fields.',
                    icon: 'warning',
                    confirmButtonColor: '#FF0000'
                });
            }
        });
    </script>
</body>
</html>
<?php
$connection->close();
?>
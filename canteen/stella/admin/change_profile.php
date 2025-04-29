<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

// Update Profile
if (isset($_POST['ChangeProfile'])) {
  $admin_id = $_SESSION['admin_id'];
  $admin_name = $_POST['admin_name'];
  $admin_email = $_POST['admin_email'];

  if (isset($_FILES['admin_profile_pic']) && $_FILES['admin_profile_pic']['error'] == 0) {
    $file_name = $_FILES['admin_profile_pic']['name'];
    $file_tmp = $_FILES['admin_profile_pic']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_extensions = array("jpg", "jpeg", "png", "gif");

    if (in_array($file_ext, $allowed_extensions)) {
      $new_file_name = uniqid() . '.' . $file_ext;
      move_uploaded_file($file_tmp, "assets/img/theme/" . $new_file_name);

      $Qry = "UPDATE rpos_admin SET admin_name = ?, admin_email = ?, admin_profile_pic = ? WHERE admin_id = ?";
      $postStmt = $mysqli->prepare($Qry);
      $postStmt->bind_param('ssss', $admin_name, $admin_email, $new_file_name, $admin_id);
      if ($postStmt->execute()) {
        $_SESSION['admin_profile_pic'] = $new_file_name;
        header("refresh:1; url=change_profile.php");
        $success = "Account Updated";
      } else {
        $err = "Please Try Again Or Try Later";
      }
    } else {
      $err = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
    }
  } else {
    $Qry = "UPDATE rpos_admin SET admin_name = ?, admin_email = ? WHERE admin_id = ?";
    $postStmt = $mysqli->prepare($Qry);
    $postStmt->bind_param('sss', $admin_name, $admin_email, $admin_id);
    if ($postStmt->execute()) {
      header("refresh:1; url=change_profile.php");
      $success = "Account Updated";
    } else {
      $err = "Please Try Again Or Try Later";
    }
  }
}

// Change Password
if (isset($_POST['changePassword'])) {
  $error = 0;
  if (!empty($_POST['old_password'])) {
    $old_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['old_password']))));
  } else {
    $error = 1;
    $err = "Old Password Cannot Be Empty";
  }
  if (!empty($_POST['new_password'])) {
    $new_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['new_password']))));
  } else {
    $error = 1;
    $err = "New Password Cannot Be Empty";
  }
  if (!empty($_POST['confirm_password'])) {
    $confirm_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['confirm_password']))));
  } else {
    $error = 1;
    $err = "Confirmation Password Cannot Be Empty";
  }

  if (!$error) {
    $admin_id = $_SESSION['admin_id'];
    $sql = "SELECT * FROM rpos_admin WHERE admin_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $admin_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
      $row = $res->fetch_assoc();
      if ($old_password != $row['admin_password']) {
        $err = "Please Enter Correct Old Password";
      } elseif ($new_password != $confirm_password) {
        $err = "Confirmation Password Does Not Match";
      } else {
        $new_password_hash = sha1(md5($_POST['new_password']));
        $query = "UPDATE rpos_admin SET admin_password = ? WHERE admin_id = ?";
        $updateStmt = $mysqli->prepare($query);
        $updateStmt->bind_param('ss', $new_password_hash, $admin_id);
        if ($updateStmt->execute()) {
          header("refresh:1; url=change_profile.php");
          $success = "Password Changed";
        } else {
          $err = "Please Try Again Or Try Later";
        }
      }
    }
  }
}

require_once('partials/_head.php');
?>

<body>
  <?php require_once('partials/_sidebar.php'); ?>
  <div class="main-content">
    <?php
    require_once('partials/_topnav.php');
    $admin_id = $_SESSION['admin_id'];
    $ret = "SELECT * FROM rpos_admin WHERE admin_id = ?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('s', $admin_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($admin = $res->fetch_object()) {
      ?>
      <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
        style="min-height: 600px; background-image: url(assets/img/theme/restro00.jpg); background-size: cover; background-position: center top;">
        <span class="mask opacity-8" style="background-color:#800000;"></span>
        <div class="container-fluid d-flex align-items-center">
          <div class="row">
            <div class="col-lg-7 col-md-10 text-2xl">
              <h1 class="display-2 text-white">Hello <?php echo htmlspecialchars($admin->admin_name); ?></h1>
              <p class="text-white mt-0 mb-5">This is your profile page. You can customize your profile and change your
                password here.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="container-fluid mt--8">
        <div class="row">
          <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow">
              <div class="row justify-content-center">
                <div class="col-lg-3 order-lg-2">
                  <div class="card-profile-image">
                    <a href="#">
                      <img
                        src="assets/img/theme/<?php echo $admin->admin_profile_pic ? htmlspecialchars($admin->admin_profile_pic) : 'user-a-min.png'; ?>?<?php echo time(); ?>"
                        class="rounded-circle bg-gray" alt="Profile Picture"
                        style="object-fit: cover; width: 150px; height: 150px; border: 3px solid #fff;">
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4"></div>
              <div class="card-body pt-0 pt-md-4">
                <div class="text-center mt-5">
                  <h3><?php echo htmlspecialchars($admin->admin_name); ?></h3>
                  <div class="h5 font-weight-300">
                    <i class="ni location_pin mr-2"></i><?php echo htmlspecialchars($admin->admin_email); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
              <div class="card-header bg-white border-0">
                <div class="row align-items-center">
                  <div class="col-8">
                    <h3 class="mb-0">My Account</h3>
                  </div>
                </div>
              </div>
              <div class="card-body">

                <form method="post" enctype="multipart/form-data" id="updateProfileForm">
                  <h6 class="heading-small text-muted mb-4">User Information</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-username">User Name</label>
                          <input type="text" name="admin_name" value="<?php echo htmlspecialchars($admin->admin_name); ?>"
                            id="input-username" class="form-control form-control-alternative">
                        </div>
                      </div>

                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-email">Email address</label>
                          <input type="email" id="input-email"
                            value="<?php echo htmlspecialchars($admin->admin_email); ?>" name="admin_email"
                            class="form-control form-control-alternative">
                        </div>
                      </div>

                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-picture">Profile Picture</label>
                          <input type="file" name="admin_profile_pic" class="form-control form-control-alternative">
                        </div>
                      </div>

                      <div class="col-lg-12">
                        <div class="form-group">
                        <input type="button" onclick="confirmUpdateProfile()" class="btn btn-success form-control-alternative" value="Update Profile">

                        </div>
                      </div>
                    </div>
                  </div>
                </form>

                <hr>

                <form method="post" id="changePasswordForm">
                  <h6 class="heading-small text-muted mb-4">Change Password</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-username">Old Password</label>
                          <input type="password" name="old_password" class="form-control form-control-alternative">
                        </div>
                      </div>

                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-email">New Password</label>
                          <input type="password" name="new_password" class="form-control form-control-alternative">
                        </div>
                      </div>

                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-email">Confirm New Password</label>
                          <input type="password" name="confirm_password" class="form-control form-control-alternative">
                        </div>
                      </div>

                      <div class="col-lg-12">
                        <div class="form-group">
                        <input type="button" onclick="confirmChangePassword()" class="btn btn-success form-control-alternative" value="Change Password">

                        </div>
                      </div>
                    </div>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php require_once('partials/_footer.php'); ?>
    </div>
  </div>

  <?php require_once('partials/_scripts.php'); ?>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmUpdateProfile() {
  Swal.fire({
    title: 'Are you sure?',
    text: "Do you want to update your profile?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#28a745',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, update it!'
  }).then((result) => {
    if (result.isConfirmed) {
      // Create hidden input to simulate submit button
      let input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'ChangeProfile';  // <-- this matches your PHP
      input.value = '1';
      document.getElementById('updateProfileForm').appendChild(input);

      document.getElementById('updateProfileForm').submit();
    }
  });
}

function confirmChangePassword() {
  Swal.fire({
    title: 'Are you sure?',
    text: "Do you want to change your password?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#28a745',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, change it!'
  }).then((result) => {
    if (result.isConfirmed) {
      // Create hidden input to simulate submit button
      let input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'changePassword';  // <-- this matches your PHP
      input.value = '1';
      document.getElementById('changePasswordForm').appendChild(input);

      document.getElementById('changePasswordForm').submit();
    }
  });
}
</script>

</body>

</html>
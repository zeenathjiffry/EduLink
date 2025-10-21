<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLink - Course Setup</title>
    <link rel="stylesheet" href="<?php  echo ROOT ?>/assets/css/createClassMain.css">
    <link rel="stylesheet" href="<?php  echo ROOT ?>/assets/css/component/createClassBasicInfo.css">
    <link rel="stylesheet" href="<?php  echo ROOT ?>/assets/css/component/createClassIntendedLearners.css">
    <link rel="stylesheet" href="<?php  echo ROOT ?>/assets/css/component/createClassAdvancedInfo.css">
    
    <link rel="stylesheet" href="<?php  echo ROOT ?>/assets/css/component/createClassHeader.css">
            <link
      href="<?php  echo ROOT ?>/assets/css/component/footer-styles.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
 <?php include __DIR__ . '/Component/createClassHeader.php';?>

    <div class="container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Plan your Class</h2>
                <p class="sidebar-subtitle">Create your own class</p>
            </div>
            
            <nav class="sidebar-nav">
                <div class="sidebar-item active" data-target="view-intended">
                    <div class="sidebar-item-content">
                        <span class="sidebar-item-title">Intended Learners</span>
                    </div>
                </div>

                <div class="sidebar-item" data-target="view-core">
                    <div class="sidebar-item-content">
                        <span class="sidebar-item-title">Basic Information</span>
                    </div>
                </div>

                <div class="sidebar-item" data-target="view-advance">
                    <div class="sidebar-item-content">
                        <span class="sidebar-item-title">Advanced Information</span>                    
                    </div>
                </div>
            </nav>

            <div class="sidebar-footer">
        </aside>

        <main class="main-content">
            <!-- Intended Learners -->
            <section id="view-intended" class="view">
            <?php include __DIR__.'/Component/createClassIntendedLearners.view.php';?>
            </section>
            
            <!-- Basic Information -->
            <section id="view-core" class="view" hidden>
               <?php include __DIR__.'/Component/createClassBasicInfo.view.php'; ?>
            </section>
            
            <!-- Advanced Information -->
            <section id="view-advance" class="view" hidden>
               <?php include __DIR__.'/Component/createClassAdvancedInfo.view.php'; ?>
            </section>
        </main>
    </div>

    <footer class="footer">
        <?php include __DIR__.'/Component/footer.view.php'; ?>
    </footer>
    
    <script src="<?php  echo ROOT ?>/assets/js/createClassMain.js"></script>
</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.html");
    exit();
}


$full_name   = htmlspecialchars($_POST['full_name'] ?? '');
$title       = htmlspecialchars($_POST['title'] ?? '');
$email       = htmlspecialchars($_POST['email'] ?? '');
$phone       = htmlspecialchars($_POST['phone'] ?? '');
$location    = htmlspecialchars($_POST['location'] ?? '');
$summary     = htmlspecialchars($_POST['summary'] ?? '');
$degree      = htmlspecialchars($_POST['degree'] ?? '');
$university  = htmlspecialchars($_POST['university'] ?? '');
$edu_year    = htmlspecialchars($_POST['edu_year'] ?? '');
$job_title   = htmlspecialchars($_POST['job_title'] ?? '');
$company     = htmlspecialchars($_POST['company'] ?? '');
$exp_year    = htmlspecialchars($_POST['exp_year'] ?? '');
$job_desc    = htmlspecialchars($_POST['job_desc'] ?? '');
$skills      = htmlspecialchars($_POST['skills'] ?? '');


$profile_pic = '';
if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
    $allowed = ['jpg', 'jpeg', 'png'];
    $file_ext = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
    
    if (in_array($file_ext, $allowed)) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $new_file_name = 'profile_' . time() . '.' . $file_ext;
        $destination = $upload_dir . $new_file_name;
        
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $destination)) {
            $profile_pic = $destination;
        }
    }
}

$skills_array = array_filter(array_map('trim', explode(',', $skills)));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $full_name; ?> - CV</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7f9;
            padding: 40px 20px;
            line-height: 1.6;
        }
        .cv-container {
            max-width: 850px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 30px rgba(0,0,0,0.15);
            border-radius: 15px;
            overflow: hidden;
        }
        .cv-header {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            color: white;
            padding: 40px 50px;
            display: flex;
            align-items: center;
            gap: 30px;
        }
        .profile-pic {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            border: 6px solid white;
            object-fit: cover;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .header-info h1 {
            font-size: 2.4rem;
            margin-bottom: 8px;
        }
        .header-info p {
            font-size: 1.3rem;
            opacity: 0.95;
        }
        .contact-info {
            margin-top: 15px;
            font-size: 0.95rem;
            opacity: 0.9;
        }
        .cv-body {
            padding: 50px;
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 40px;
        }
        .left-column, .right-column {
            padding: 0 10px;
        }
        h2 {
            color: #4e54c8;
            border-bottom: 3px solid #e0e4ff;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        .skill-item {
            background: #f8f9ff;
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            border-left: 4px solid #4e54c8;
        }
        .section {
            margin-bottom: 35px;
        }
        .job, .edu {
            margin-bottom: 25px;
        }
        .print-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            padding: 12px 25px;
            background: #4e54c8;
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        @media print {
            .print-btn { display: none; }
            body { padding: 0; background: white; }
        }
    </style>
</head>
<body>
    <div class="cv-container">
        
        <div class="cv-header">
            <?php if ($profile_pic): ?>
                <img src="<?php echo $profile_pic; ?>" alt="Profile Picture" class="profile-pic">
            <?php else: ?>
                <div style="width:160px;height:160px;background:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:60px;color:#4e54c8;">👤</div>
            <?php endif; ?>
            
            <div class="header-info">
                <h1><?php echo $full_name; ?></h1>
                <p><?php echo $title; ?></p>
                <div class="contact-info">
                    <?php echo $email; ?> | <?php echo $phone; ?> | <?php echo $location; ?>
                </div>
            </div>
        </div>

        <div class="cv-body">
           
            <div class="left-column">
                <div class="section">
                    <h2>Summary</h2>
                    <p><?php echo nl2br($summary); ?></p>
                </div>

                <div class="section">
                    <h2>Skills</h2>
                    <?php foreach ($skills_array as $skill): ?>
                        <div class="skill-item"><?php echo htmlspecialchars($skill); ?></div>
                    <?php endforeach; ?>
                </div>
            </div>

           
            <div class="right-column">
                <div class="section">
                    <h2>Experience</h2>
                    <div class="job">
                        <strong><?php echo $job_title; ?></strong><br>
                        <em><?php echo $company; ?> — <?php echo $exp_year; ?></em>
                        <p style="margin-top:10px;"><?php echo nl2br($job_desc); ?></p>
                    </div>
                </div>

                <div class="section">
                    <h2>Education</h2>
                    <div class="edu">
                        <strong><?php echo $degree; ?></strong><br>
                        <em><?php echo $university; ?></em><br>
                        <span><?php echo $edu_year; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button onclick="window.print()" class="print-btn">🖨️ Print / Save as PDF</button>
</body>
</html>
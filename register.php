<?php
// إعداد الاتصال بقاعدة البيانات
$dsn = "mysql:host=localhost;dbname=student_management;charset=utf8";
$username = "root"; // غيّرها حسب إعدادك
$password = "";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = trim($_POST['student_name']);
        $email = trim($_POST['email']);
        $student_number = trim($_POST['student_number']);
        $year = intval($_POST['year_of_study']);
        $batch = trim($_POST['batch_name']);

        // التحقق من صحة البريد الإلكتروني
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<p style='color:red'>البريد الإلكتروني غير صالح</p>";
        } else {
            $stmt = $pdo->prepare("INSERT INTO students (student_name, email, student_number, year_of_study, batch_name) 
                                   VALUES (:name, :email, :student_number, :year, :batch)");
            try {
                $stmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':student_number' => $student_number,
                    ':year' => $year,
                    ':batch' => $batch
                ]);
                echo "<p style='color:green'>تم التسجيل بنجاح ✅</p>";
            } catch (PDOException $e) {
                echo "<p style='color:red'>خطأ: " . $e->getMessage() . "</p>";
            }
        }
    }
} catch (PDOException $e) {
    die("فشل الاتصال: " . $e->getMessage());
}
?>

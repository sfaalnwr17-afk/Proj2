<?php
$dsn = "mysql:host=localhost;dbname=student_management;charset=utf8";
$username = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // حذف طالب
    if (isset($_GET['delete'])) {
        $id = intval($_GET['delete']);
        $stmt = $pdo->prepare("DELETE FROM students WHERE id = :id");
        $stmt->execute([':id' => $id]);
        echo "<p style='color:green'>تم حذف الطالب بنجاح ✅</p>";
    }

    // جلب جميع الطلاب
    $stmt = $pdo->query("SELECT * FROM students ORDER BY created_at DESC");
    $students = $stmt->fetchAll();
} catch (PDOException $e) {
    die("خطأ: " . $e->getMessage());
}
?>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>الاسم</th>
        <th>البريد الإلكتروني</th>
        <th>الرقم الجامعي</th>
        <th>السنة</th>
        <th>الدفعة</th>
        <th>تاريخ التسجيل</th>
        <th>إجراء</th>
    </tr>
    <?php foreach ($students as $student): ?>
    <tr>
        <td><?= $student['id'] ?></td>
        <td><?= htmlspecialchars($student['student_name']) ?></td>
        <td><?= htmlspecialchars($student['email']) ?></td>
        <td><?= htmlspecialchars($student['student_number']) ?></td>
        <td><?= $student['year_of_study'] ?></td>
        <td><?= htmlspecialchars($student['batch_name']) ?></td>
        <td><?= $student['created_at'] ?></td>
        <td><a href="students.php?delete=<?= $student['id'] ?>" onclick="return confirm('هل أنت متأكد من الحذف؟')">🗑 حذف</a></td>
    </tr>
    <?php endforeach; ?>
</table>

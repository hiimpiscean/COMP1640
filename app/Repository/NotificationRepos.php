<?php
namespace Repositories;

use PDO;
use PDOException;

class NotificationRepos {
    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    // Tạo thông báo cho staff khi sinh viên đăng ký
    public function createStaffStudentRegistrationNotification($studentId, $courseId) {
        try {
            $query = "INSERT INTO notifications
                      (user_type, user_id, message, type, related_id, is_read, created_at)
                      VALUES
                      ('staff', :staff_id, :message, 'student_registration', :student_id, 0, NOW())";

            $stmt = $this->conn->prepare($query);

            // Lấy staff_id phụ trách khóa học
            $staffQuery = "SELECT staff_id FROM courses WHERE id = :course_id";
            $staffStmt = $this->conn->prepare($staffQuery);
            $staffStmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);
            $staffStmt->execute();
            $staffId = $staffStmt->fetchColumn();

            $message = "Sinh viên mới đăng ký khóa học. Cần xếp lớp.";

            $stmt->bindParam(':staff_id', $staffId, PDO::PARAM_INT);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);
            $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);

            return $stmt->execute() ? $this->conn->lastInsertId() : false;
        } catch (PDOException $e) {
            // Ghi log lỗi
            return false;
        }
    }

    // Tạo thông báo cho giáo viên khi sinh viên được xếp lớp
    public function createTeacherClassAssignmentNotification($studentId, $classId) {
        try {
            $query = "INSERT INTO notifications
                      (user_type, user_id, message, type, related_id, is_read, created_at)
                      VALUES
                      ('teacher', :teacher_id, :message, 'student_assigned', :student_id, 0, NOW())";

            $stmt = $this->conn->prepare($query);

            // Lấy teacher_id của lớp
            $teacherQuery = "SELECT teacher_id FROM classes WHERE id = :class_id";
            $teacherStmt = $this->conn->prepare($teacherQuery);
            $teacherStmt->bindParam(':class_id', $classId, PDO::PARAM_INT);
            $teacherStmt->execute();
            $teacherId = $teacherStmt->fetchColumn();

            $message = "Sinh viên mới được xếp vào lớp của bạn.";

            $stmt->bindParam(':teacher_id', $teacherId, PDO::PARAM_INT);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);
            $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);

            return $stmt->execute() ? $this->conn->lastInsertId() : false;
        } catch (PDOException $e) {
            // Ghi log lỗi
            return false;
        }
    }

    // Tạo thông báo xác nhận lớp cho sinh viên
    public function createStudentClassConfirmationNotification($studentId, $classId) {
        try {
            $query = "INSERT INTO notifications
                      (user_type, user_id, message, type, related_id, is_read, action_url, created_at)
                      VALUES
                      ('student', :student_id, :message, 'class_confirmation', :class_id, 0, :action_url, NOW())";

            $stmt = $this->conn->prepare($query);

            $message = "Bạn đã được xếp vào lớp. Vui lòng xác nhận.";
            $actionUrl = "/student/class-confirmation/{$classId}";

            $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);
            $stmt->bindParam(':class_id', $classId, PDO::PARAM_INT);
            $stmt->bindParam(':action_url', $actionUrl, PDO::PARAM_STR);

            return $stmt->execute() ? $this->conn->lastInsertId() : false;
        } catch (PDOException $e) {
            // Ghi log lỗi
            return false;
        }
    }

    // Lấy thông báo theo loại người dùng và ID
    public function getNotificationsByUser($userType, $userId, $limit = 10, $offset = 0) {
        try {
            $query = "SELECT * FROM notifications
                      WHERE user_type = :user_type AND user_id = :user_id
                      ORDER BY created_at DESC
                      LIMIT :limit OFFSET :offset";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_type', $userType, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // Đánh dấu thông báo đã đọc
    public function markNotificationAsRead($notificationId) {
        try {
            $query = "UPDATE notifications SET is_read = 1 WHERE id = :notification_id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':notification_id', $notificationId, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}

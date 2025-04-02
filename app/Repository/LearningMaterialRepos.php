<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\LearningMaterial;
use Exception;

class LearningMaterialRepos
{
    /**
     * Lấy tất cả tài liệu đã được phê duyệt
     */
    public function getAllApprovedMaterials()
    {
        return LearningMaterial::where('status', 'approved')->get();
    }

    /**
     * Lấy tài liệu theo ID
     */
    public function getMaterialById($id)
    {
        return LearningMaterial::findOrFail($id);
    }

    /**
     * Tạo tài liệu mới
     */
    public function create($data)
    {
        return LearningMaterial::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'file_path' => $data['file_path'],
            'teacher_id' => $data['teacher_id'],
            'status' => 'pending',
        ]);
    }

    /**
     * Cập nhật thông tin tài liệu
     */
    public function update($id, $data)
    {
        return LearningMaterial::where('id', $id)->update($data);
    }

    /**
     * Xóa tài liệu
     */
    public function delete($id)
    {
        return LearningMaterial::findOrFail($id)->delete();
    }

    /**
     * Lấy danh sách tài liệu chờ duyệt
     */
    public function getPendingMaterials()
    {
        return LearningMaterial::where('status', 'pending')->get();
    }

    /**
     * Phê duyệt tài liệu
     */
    public function approveMaterial($id, $staff_id)
    {
        return LearningMaterial::where('id', $id)->update([
            'status' => 'approved',
            'staff_id' => $staff_id,
        ]);
    }

    /**
     * Từ chối tài liệu
     */
    public function rejectMaterial($id, $staff_id)
    {
        return LearningMaterial::where('id', $id)->update([
            'status' => 'rejected',
            'staff_id' => $staff_id,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleMeetService;
use App\Models\Timetable;
use App\Repository\TimetableRepos;
use Illuminate\Support\Facades\Log;

class TimetableController extends Controller
{
    /**
     * @var GoogleMeetService
     */
    protected $googleMeetService;
    protected $timetableRepos;

    /**
     * Khởi tạo controller với GoogleMeetService
     * 
     * @param GoogleMeetService $googleMeetService
     */
    public function __construct(GoogleMeetService $googleMeetService, TimetableRepos $timetableRepos)
    {
        $this->googleMeetService = $googleMeetService;
        $this->timetableRepos = $timetableRepos;
    }

    /**
     * Hiển thị danh sách lịch học
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $timetable = $this->timetableRepos->getAllTimetables();
        $courses = $this->timetableRepos->getCourses();
        $teachers = $this->timetableRepos->getTeachers();

        return view('timetable.index', compact('timetable', 'courses', 'teachers'));
    }

    /**
     * Hiển thị form tạo lịch học mới
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        try {
            $courses = $this->timetableRepos->getCourses();
            $teachers = $this->timetableRepos->getTeachers();

            return view('timetable.create', compact('courses', 'teachers'));
        } catch (\Exception $e) {
            Log::error('Lỗi khi hiển thị form tạo lịch học: ' . $e->getMessage());
            return redirect()->route('timetable.index')
                ->with('error', 'Có lỗi xảy ra khi tải form tạo lịch học: ' . $e->getMessage());
        }
    }

    /**
     * Lưu lịch học mới vào database
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|integer',
            'teacher_id' => 'required|integer|exists:teacher,id_t',
            'day_of_week' => 'required|string|max:20',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'location' => 'nullable|string|max:100',
        ]);

        try {
            $id = $this->timetableRepos->create($request->all());

            if ($request->location === 'online') {
                try {
                    $timetableObj = new Timetable();
                    $timetableObj->id = $id;
                    $timetableObj->course_id = $request->course_id;
                    $timetableObj->teacher_id = $request->teacher_id;
                    $timetableObj->day_of_week = $request->day_of_week;
                    $timetableObj->start_time = $request->start_time;
                    $timetableObj->end_time = $request->end_time;
                    $timetableObj->location = $request->location;
                    
                    $timetableObj->course = $this->timetableRepos->getCourseById($request->course_id);
                    $timetableObj->teacher = $this->timetableRepos->getTeacherById($request->teacher_id);
                    
                    $meetLink = $this->googleMeetService->createMeetLinkForTimetable($timetableObj);
                    if ($meetLink) {
                        $this->timetableRepos->updateMeetLink($id, $meetLink);
                    }
                } catch (\Exception $e) {
                    Log::error('Không thể tạo Google Meet link: ' . $e->getMessage());
                }
            }

            return redirect()->route('timetable.index')->with('success', 'Tạo lịch học mới thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi khi tạo lịch học mới: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi tạo lịch học mới: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Hiển thị thông tin chi tiết của lịch học
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        try {
            $timetable = $this->timetableRepos->getTimetableById($id);
            return view('timetable.show', compact('timetable'));
        } catch (\Exception $e) {
            Log::error('Lỗi khi hiển thị chi tiết lịch học: ' . $e->getMessage());
            return redirect()->route('timetable.index')->with('error', 'Không tìm thấy lịch học này.');
        }
    }

    /**
     * Hiển thị form chỉnh sửa lịch học
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        try {
            $timetable = $this->timetableRepos->getTimetableById($id);
            $courses = $this->timetableRepos->getCourses();
            $teachers = $this->timetableRepos->getTeachers();

            return view('timetable.edit', compact('timetable', 'courses', 'teachers'));
        } catch (\Exception $e) {
            Log::error('Lỗi khi hiển thị form chỉnh sửa lịch học: ' . $e->getMessage());
            return redirect()->route('timetable.index')->with('error', 'Không tìm thấy lịch học này.');
        }
    }

    /**
     * Cập nhật thông tin lịch học
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'course_id' => 'required|integer',
            'teacher_id' => 'required|integer|exists:teacher,id_t',
            'day_of_week' => 'required|string|max:20',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'location' => 'required|string|max:100',
        ]);

        try {
            $oldLocation = $this->timetableRepos->getLocation($id);
            $meetLink = null;
            
            if ($request->location === 'online' && $oldLocation !== 'online') {
                try {
                    $timetableObj = new Timetable();
                    $timetableObj->id = $id;
                    $timetableObj->course_id = $request->course_id;
                    $timetableObj->teacher_id = $request->teacher_id;
                    $timetableObj->day_of_week = $request->day_of_week;
                    $timetableObj->start_time = $request->start_time;
                    $timetableObj->end_time = $request->end_time;
                    $timetableObj->location = $request->location;
                    
                    $timetableObj->course = $this->timetableRepos->getCourseById($request->course_id);
                    $timetableObj->teacher = $this->timetableRepos->getTeacherById($request->teacher_id);
                    
                    $meetLink = $this->googleMeetService->createMeetLinkForTimetable($timetableObj);
                } catch (\Exception $e) {
                    Log::error('Không thể tạo Google Meet link: ' . $e->getMessage());
                }
            }

            $data = $request->all();
            $data['meet_link'] = $meetLink;
            
            $this->timetableRepos->update($id, $data);

            return redirect()->route('timetable.index')->with('success', 'Cập nhật lịch học thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật lịch học: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi cập nhật lịch học: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Xóa lịch học
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $this->timetableRepos->delete($id);
            return redirect()->route('timetable.index')->with('success', 'Xóa lịch học thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa lịch học: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa lịch học: ' . $e->getMessage());
        }
    }

    /**
     * Tạo Google Meet link cho một lịch học
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generateMeetLink($id)
    {
        try {
            $timetable = $this->timetableRepos->getTimetableById($id);
            
            if (!$timetable) {
                return redirect()->back()->with('error', 'Không tìm thấy lịch học này.');
            }
            
            $timetableObj = new Timetable();
            $timetableObj->id = $id;
            $timetableObj->course_id = $timetable->course_id;
            $timetableObj->teacher_id = $timetable->teacher_id;
            $timetableObj->day_of_week = $timetable->day_of_week;
            $timetableObj->start_time = $timetable->start_time;
            $timetableObj->end_time = $timetable->end_time;
            $timetableObj->location = $timetable->location;
            
            $timetableObj->course = $this->timetableRepos->getCourseById($timetable->course_id);
            $timetableObj->teacher = $this->timetableRepos->getTeacherById($timetable->teacher_id);
            
            $meetLink = $this->googleMeetService->createMeetLinkForTimetable($timetableObj);
            
            if (!$meetLink) {
                return redirect()->back()->with('error', 'Không thể tạo Google Meet link.');
            }

            $this->timetableRepos->updateMeetLink($id, $meetLink);

            return redirect()->back()->with('success', 'Tạo Google Meet link thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi khi tạo Google Meet link: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo Google Meet link: ' . $e->getMessage());
        }
    }

    /**
     * Tạo Google Meet link cho tất cả các lịch học của một khóa học
     *
     * @param int $courseId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generateMeetLinksForCourse($courseId)
    {
        try {
            $timetables = $this->timetableRepos->getTimetablesByCourseId($courseId);

            if ($timetables->isEmpty()) {
                return redirect()->back()->with('error', 'Không tìm thấy lịch học nào cho khóa học này.');
            }

            $successCount = 0;
            $failCount = 0;

            foreach ($timetables as $timetable) {
                try {
                    $timetableObj = new Timetable();
                    $timetableObj->id = $timetable->id;
                    $timetableObj->course_id = $timetable->course_id;
                    $timetableObj->teacher_id = $timetable->teacher_id;
                    $timetableObj->day_of_week = $timetable->day_of_week;
                    $timetableObj->start_time = $timetable->start_time;
                    $timetableObj->end_time = $timetable->end_time;
                    $timetableObj->location = $timetable->location;
                    
                    $timetableObj->course = $this->timetableRepos->getCourseById($timetable->course_id);
                    $timetableObj->teacher = $this->timetableRepos->getTeacherById($timetable->teacher_id);
                    
                    $meetLink = $this->googleMeetService->createMeetLinkForTimetable($timetableObj);
                    if ($meetLink) {
                        $this->timetableRepos->updateMeetLink($timetable->id, $meetLink);
                        $successCount++;
                    } else {
                        $failCount++;
                    }
                } catch (\Exception $e) {
                    Log::error('Lỗi khi tạo Google Meet link cho lịch học ID ' . $timetable->id . ': ' . $e->getMessage());
                    $failCount++;
                }
            }

            if ($failCount > 0) {
                return redirect()->back()
                    ->with('warning', "Đã tạo thành công $successCount link, nhưng có $failCount link không thể tạo được.");
            }

            return redirect()->back()->with('success', "Đã tạo thành công $successCount Google Meet link.");
        } catch (\Exception $e) {
            Log::error('Lỗi khi tạo Google Meet link cho khóa học: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi tạo Google Meet link: ' . $e->getMessage());
        }
    }
}
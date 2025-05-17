<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Repositories\TaskRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{

    /**
     * @OA\Info(
     *     title="Task Management API",
     *     version="1.0.0",
     *     description="مستندات مربوط به API مدیریت وظایف"
     * )
     *
     * @OA\Server(
     *     url=L5_SWAGGER_CONST_HOST,
     *     description="Laravel API Server"
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/index/tasks",
     *     summary="دریافت لیست وظایف",
     *     tags={"Tasks"},
     *     @OA\Response(
     *         response=200,
     *         description="لیست وظایف با موفقیت دریافت شد",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="عملیات با موفقیت انجام شد."),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="عنوان تست"),
     *                     @OA\Property(property="description", type="string", example="توضیحات تست"),
     *                     @OA\Property(property="priority", type="string", example="medium"),
     *                     @OA\Property(property="status", type="string", example="pending"),
     *                     @OA\Property(property="end_date", type="string", example="1403/02/01"),
     *                     @OA\Property(property="created_at", type="string", example="2025-05-17T10:30:00Z"),
     *                     @OA\Property(property="updated_at", type="string", example="2025-05-17T10:30:00Z")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(TaskRepo $taskRepo)
    {
        return response()->json([
            'message' => 'عملیات با موفقیت انجام شد.',
            'data' => $taskRepo->getAll()
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/store/tasks",
     *     summary="ایجاد یک وظیفه جدید",
     *     tags={"Tasks"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","description","priority","status"},
     *             @OA\Property(property="title", type="string", example="عنوان تست"),
     *             @OA\Property(property="description", type="string", example="توضیحات تست"),
     *             @OA\Property(property="priority", type="string", enum={"low","medium","high"}, example="medium"),
     *             @OA\Property(property="status", type="string", enum={"pending","in_progress","completed"}, example="pending"),
     *             @OA\Property(property="end_date", type="string", example="1403/02/01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="وظیفه با موفقیت ایجاد شد"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطا در سرور"
     *     )
     * )
     */
    public function store(Request $request, TaskRepo $taskRepo)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'end_date' => 'nullable|string',
        ]);

        try {
            $task = $taskRepo->store($data);
            return response()->json($task, 201);
        } catch (\Exception $e) {
            Log::error('خطا در ایجاد وظیفه: ' . $e->getMessage());
            return response()->json([
                'message' => 'در ذخیره‌سازی وظیفه خطایی رخ داد.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/update/tasks/{id}",
     *     summary="ویرایش یک وظیفه",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="شناسه وظیفه",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","description","priority","status"},
     *             @OA\Property(property="title", type="string", example="عنوان ویرایش شده"),
     *             @OA\Property(property="description", type="string", example="توضیح ویرایش شده"),
     *             @OA\Property(property="priority", type="string", enum={"low","medium","high"}, example="high"),
     *             @OA\Property(property="status", type="string", enum={"pending","in_progress","completed"}, example="completed"),
     *             @OA\Property(property="end_date", type="string", example="1403/02/20")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="وظیفه با موفقیت به‌روزرسانی شد"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطا در سرور"
     *     )
     * )
     */
    public function update($id, Request $request, TaskRepo $taskRepo)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'end_date' => 'required|string',
        ]);

        try {
            $task = $taskRepo->updateTask($id, $data);
            return response()->json([
                'message' => 'عملیات با موفقیت انجام شد.',
                'data' => $task
            ], 200);
        } catch (\Exception $e) {
            Log::error('خطا در ویرایش وظیفه: ' . $e->getMessage());
            return response()->json([
                'message' => 'در ویرایش وظیفه خطایی رخ داد.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/delete/tasks/{id}",
     *     summary="حذف یک وظیفه",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="شناسه وظیفه",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="وظیفه با موفقیت حذف شد"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="خطا در سرور"
     *     )
     * )
     */
    public function destroy($id, TaskRepo $taskRepo)
    {
        try {
            $task = $taskRepo->destroyTask($id);
            return response()->json([
                'message' => 'عملیات با موفقیت انجام شد.',
                'data' => $task
            ], 200);
        } catch (\Exception $e) {
            Log::error('خطا در حذف وظیفه: ' . $e->getMessage());
            return response()->json([
                'message' => 'در حذف وظیفه خطایی رخ داد.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

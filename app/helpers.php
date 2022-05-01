<?php

use Illuminate\Http\JsonResponse;

if (!function_exists('success')) {
  /**
   * 返回成功状态
   *
   * @param mixed $data
   * @param int|string $code
   * @return JsonResponse
   */
  function success(mixed $data = null, int|string $code = 'code.0'): JsonResponse
  {
    if (isset($data)) {

      return response()->json([
        'success' => true,
        'code' => $code,
        'message' => __($code),
        'data' => $data
      ]);
    } else {

      return response()->json([
        'success' => true,
        'code' => $code,
        'message' => 'ok',
      ]);
    }
  }
}

if (!function_exists('error')) {
  /**
   * 返回失败状态
   *
   * @param int|string $code
   * @param string|null $message
   * @param mixed $data
   * @return JsonResponse
   */
  function error(int|string $code = 'code.-1', string $message = null, mixed $data = null): JsonResponse
  {
    if (isset($data)) {
      return response()->json([
        'success' => false,
        'code' => $code,
        'message' => $message ?? __($code),
        'errorData' => $data
      ]);
    } else {
      return response()->json([
        'success' => false,
        'code' => $code,
        'message' => $message ?? __($code),
      ]);
    }
  }
}

if (!function_exists('result')) {
  /**
   * 自动判断返回结果
   *
   * @param mixed $data
   * @param int|string $code
   * @return JsonResponse
   */
  function result(mixed $data, int|string $code = 'code.0'): JsonResponse
  {
    if (isset($data) && (bool) $data) {

      return response()->json([
        'success' => true,
        'code' => $code,
        'message' => __($code),
        'data' => $data
      ]);
    } else {

      if ($code == 'code.0') {
        $code = 'code.-1';
      }

      return response()->json([
        'success' => false,
        'code' => $code,
        'message' => __($code),
      ]);
    }
  }
}

if (!function_exists('resultStatus')) {
    /**
     * 自动判断返回结果，简单返回状态
     *
     * @param mixed $data
     * @return JsonResponse
     */
  function resultStatus(mixed $data): JsonResponse
  {
    if (isset($data) && (bool) $data) {
      return response()->json([
        'success' => true,
        'code' => 'code.0',
        'message' => __('code.0'),
      ]);
    } else {
      return response()->json([
        'success' => false,
        'code' => 'code.-1',
        'message' => __('code.-1'),
      ]);
    }
  }
}

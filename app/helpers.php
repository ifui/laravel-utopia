<?php

if (!function_exists('success')) {
  /**
   * 返回成功状态
   *
   * @param mixed $data
   * @param string $code
   * @return Response
   */
  function success(mixed $data = null, int|string $code = '0')
  {
    if (isset($data)) {

      return response()->json([
        'success' => true,
        'code' => $code,
        'message' => __('code.' . $code),
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
   * @param string $code
   * @param string $message
   * @return Response
   */
  function error(int|string $code = '-1', $message = null)
  {
    return response()->json([
      'success' => false,
      'code' => $code,
      'message' => isset($message) ? $message : __('code.' . $code),
    ]);
  }
}

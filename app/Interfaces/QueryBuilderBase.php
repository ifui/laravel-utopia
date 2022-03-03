<?php

namespace App\Interfaces;

interface QueryBuilderBase
{
  /**
   * 关联
   *
   * @return array
   */
  public static function include();

  /**
   * 排序
   *
   * @return array
   */
  public static function sort();

  /**
   * 修改器
   *
   * @return array
   */
  public static function append();

  /**
   * 过滤、搜索
   *
   * @return array
   */
  public static function filter();

  /**
   * 选择性字段
   *
   * @return array
   */
  public static function field();
}

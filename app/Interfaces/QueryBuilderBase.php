<?php

namespace App\Interfaces;

interface QueryBuilderBase
{
  /**
   * 关联
   *
   * @return void
   */
  public static function include();

  /**
   * 排序
   *
   * @return void
   */
  public static function sort();

  /**
   * 修改器
   *
   * @return void
   */
  public static function append();

  /**
   * 过滤、搜索
   *
   * @return void
   */
  public static function filter();

  /**
   * 选择性字段
   *
   * @return void
   */
  public static function field();
}

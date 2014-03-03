<?php
namespace Phpingguo\CitronDI;

use Symfony\Component\Yaml\Parser;

/**
 * DIラッパークラスが使用するプリセットサービスの一覧を管理するクラスです。
 * 
 * @final [継承禁止クラス]
 * @author hiroki sugawara
 */
final class DIPresetServices
{
    // ---------------------------------------------------------------------------------------------
    // class fields
    // ---------------------------------------------------------------------------------------------
    public static $preset_services = [];
    
    // ---------------------------------------------------------------------------------------------
    // public class methods
    // ---------------------------------------------------------------------------------------------
    /**
     * DIコンテナラッパーが使用するプリセットサービスの一覧を取得します。
     * 
     * @param String $service_group_name             プリセットサービス一覧のグループ名
     * @param Boolean $is_force_reset [初期値=false] 強制的に初期化するかどうか
     * 
     * @return Array DIコンテナラッパーが使用するプリセットサービスの一覧
     */
    public static function get($service_group_name, $is_force_reset = false)
    {
        return static::getInitializedList($service_group_name, $is_force_reset);
    }
    
    // ---------------------------------------------------------------------------------------------
    // private class methods
    // ---------------------------------------------------------------------------------------------
    /**
     * 初期化済みのDIコンテナラッパーが使用するプリセットサービスの一覧を取得します。
     * 
     * @param String $service_group_name プリセットサービス一覧のグループ名
     * @param Boolean $is_force_reset    強制的に初期化するかどうか
     * 
     * @return Array DIコンテナラッパーが使用するプリセットサービスの一覧
     */
    private static function getInitializedList($service_group_name, $is_force_reset)
    {
        if (static::isInitialized($service_group_name, $is_force_reset)) {
            static::setPresetServices($service_group_name, static::getParsedServices($service_group_name));
        }
        
        return static::getPresetServices($service_group_name);
    }

    /**
     * プリセットサービスの一覧を初期化するかどうかを判定します。
     * 
     * @param String $service_group_name プリセットサービス一覧のグループ名
     * @param Boolean $is_force_reset 強制的に初期化するかどうか
     * 
     * @return Boolean 初期化処理を実行する場合は true。それ以外の場合は false。
     */
    private static function isInitialized($service_group_name, $is_force_reset)
    {
        return (empty(static::$preset_services[$service_group_name]) || $is_force_reset === true);
    }

    /**
     * プリセットサービスの一覧を設定します。
     * 
     * @param String $service_group_name プリセットサービス一覧のグループ名
     * @param Array $service_list プリセットサービスとして登録するリスト
     */
    private static function setPresetServices($service_group_name, array $service_list)
    {
        static::$preset_services[$service_group_name] = $service_list;
    }

    /**
     * プリセットサービスの一覧を取得します。
     * 
     * @param String $service_group_name プリセットサービス一覧のグループ名
     * 
     * @return Array プリセットサービスの一覧
     */
    private static function getPresetServices($service_group_name)
    {
        return static::$preset_services[$service_group_name];
    }

    /**
     * プリセットサービスの一覧を定義しているファイルの解析結果を配列として取得します。
     * 
     * @param String $service_group_name プリセットサービス一覧のグループ名
     * 
     * @return Array|null 解析成功時はプリセットサービスの配列。解析失敗時は null。
     */
    private static function getParsedServices($service_group_name)
    {
        $dir   = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'config';
        $file  = "{$service_group_name}_preset_services.yml";
        $path  = $dir . DIRECTORY_SEPARATOR . $file;
        $value = (new Parser())->parse(file_get_contents($path));
        
        return is_array($value) ? $value : null;
    }
}

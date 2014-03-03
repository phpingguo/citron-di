<?php
namespace Phpingguo\CitronDI;

use Aura\Di\Config as DiConfig;
use Aura\Di\Container;
use Aura\Di\Forge;

/**
 * AuraのDIコンテナをラップするクラスです。
 * 
 * @final [継承禁止クラス]
 * @author hiroki sugawara
 */
final class AuraDIWrapper
{
    // ---------------------------------------------------------------------------------------------
    // private class methods
    // ---------------------------------------------------------------------------------------------
    private static $aura_di     = null;
    private static $preset_list = [];
    
    // ---------------------------------------------------------------------------------------------
    // public class methods
    // ---------------------------------------------------------------------------------------------
    /**
     * AuraDIWrapper クラスのインスタンスを初期化します。
     * 
     * @param String $service_group_name [初期値='system'] プリセットサービス一覧のグループ名
     * 
     * @return \Aura\Di\Container 初期化したクラスが保持する DI コンテナのインスタンスを返します。
     */
    public static function init($service_group_name = 'system')
    {
        static::setPresetServices($service_group_name, DIPresetServices::get($service_group_name));
        
        static::setContainer(
            static::registryServices(
                static::initContainer(static::$aura_di),
                static::getPresetServices($service_group_name)
            )
        );
        
        return static::getContainer();
    }
    
    // ---------------------------------------------------------------------------------------------
    // private class methods
    // ---------------------------------------------------------------------------------------------
    /**
     * DIコンテナのインスタンスを取得します。
     * 
     * @return Container DIコンテナのインスタンス
     */
    private static function getContainer()
    {
        return static::$aura_di;
    }
    
    /**
     * DIコンテナのインスタンスを設定します。
     * 
     * @param Container $container	新しく設定するDIコンテナのインスタンス
     */
    private static function setContainer(Container $container)
    {
        static::$aura_di = $container;
    }
    
    /**
     * DIコンテナに登録するサービスのプリセットのリストを取得します。
     *
     * @param String $service_group_name プリセットサービス一覧のグループ名
     *
     * @return Array サービスのプリセットのリスト
     */
    private static function getPresetServices($service_group_name)
    {
        return static::$preset_list[$service_group_name];
    }

    /**
     * DIコンテナに登録するサービスのプリセットのリストを設定します。
     * 
     * @param String $service_group_name プリセットサービス一覧のグループ名
     * @param Array $services            登録するサービスのプリセットのリスト
     */
    private static function setPresetServices($service_group_name, array $services)
    {
        if (isset(static::$preset_list[$service_group_name]) === false) {
            static::$preset_list[$service_group_name] = $services;
        }
    }
    
    /**
     * DIコンテナのインスタンスを初期化します。
     * 
     * @param Container $container [初期値=null] サービスを登録するDIコンテナのインスタンス
     * 
     * @return Container 初期化した DI コンテナのインスタンス
     */
    private static function initContainer($container = null)
    {
        empty($container) && $container = new Container(new Forge(new DiConfig()));
        
        return $container;
    }
    
    /**
     * DIコンテナにサービスを登録します。
     * 
     * @param Container $container                 サービスを登録するDIコンテナのインスタンス
     * @param Array $service_list [初期値=array()] 登録するサービスのリスト
     * 
     * @return Container サービス登録後の状態のDIコンテナのインスタンス
     */
    private static function registryServices(Container $container, array $service_list)
    {
        foreach ($service_list as $class) {
            $container->set($class, $container->lazyNew($class));
        }
        
        return $container;
    }
}

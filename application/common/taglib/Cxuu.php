<?php

namespace app\common\taglib;

use think\template\TagLib;

/**
 * 自定义标签库解析类
 * @subpackage  Driver.Taglib
 * @author    邓中华 Cdeng
 */
class Cxuu extends Taglib {

    // 标签定义
    protected $tags = [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'site' => ['attr' => 'name', 'close' => 0],
		'contentlist' => ['attr' => 'name,vo,key,mod,cid,limit,pic,order,position_a,position_b,position_c,cacheid', 'close' => 1],
		'volist' => ['attr' => 'table,key,value,status,limit,order,vo,cacheid','close'=>1],
    ];

    /**
     * cxuu  系统配置 标签解析
     * 格式：
     * {cxuu:site name="site_title"}
     * @access public
     * @param  array $tag 标签属性
     * @return string
     */
    public function tagSite($tag) {
        $name = empty($tag['name']) ? 'site_title' : $tag['name'];
        $parse = '<?php ';
        $parse .= 'echo siteSettings("'.$name.'");';
        $parse .= ' ?>';
        return $parse;
    }

	/**
     * Cxuu:contentlist 文章内容标签解析 循环输出数据集
     * 格式：
     * {cxuu:contentlist cid="4,7,5" limit="50" position_c="1" pic="true" order="id desc" vo="vo" cacheid="firsttitle" empty="没有内容"}
     * {vo.username}
     * {vo.email}
     * {/cxuu:contentlist}
     * @access public
     * @param  array $tag 标签属性
     * @param  string $content 标签内容
     * @return string|void
	 * :model('app\index\model\Content')->where('cid',5)->limit(10)->select()
     */
    public function tagContentlist($tag, $content)
    {
		$cid      = isset($tag['cid']) ? $tag['cid'] : '';//对应栏目CID
		$limit    = isset($tag['limit']) ? $tag['limit'] : '10';//查询条数 limit="10" 与 limit="2,6"  2为偏移，6为几条
		$pic      = isset($tag['pic']) ? $tag['pic'] : '';//图片内容判断
		$position = isset($tag['position']) ? $tag['position'] : '';//内容属性 头条
		$order    = isset($tag['order']) ? $tag['order'] : 'id DESC';//排序id  created_date  hits   asc  desc
		$cacheid  = isset($tag['cacheid']) ? $tag['cacheid'] : '';//缓存ID

        $name     = ":model('Content')"; //对应当前应用下的 model 方法
        $name     .= "->where('cid','in','".$cid."')";
        $name     .= "->field('id,cid,title,image,created_date')";
 		if($pic == 'true'){
			$name .= "->where('imageBL',1)";//如果有图片，则判断字段为1,利于SQL优化  索引字段
		}

		if($position == 'a'){
			$name .= "->where('position_a',1)";
		}
		if($position == 'b'){
			$name .= "->where('position_b',1)";
		}
		if($position == 'c'){
			$name .= "->where('position_c',1)";
		}
		//$name     .= "->where('status',1)";  // 定义全局的查询范围
        $name     .= "->order('".$order."')";
        $name     .= "->limit(".$limit.")";
        $name     .= "->select()";

        $vo       = isset($tag['vo']) ? $tag['vo'] : 'vo';//识别标签
        $empty    = isset($tag['empty']) ? $tag['empty'] : ''; //为空时显示内容  empty="没有内容"

        $parseStr = '<?php ';
		$name = $this->autoBuildVar($name); //获取变量用于SQL条件

        //随机缓存时间 1--800秒
        $randtime = rand(10,200)."0";

		/*增加缓存规则*/
		if(!empty($cacheid)){
			$parseStr .= 'if(Cache::get("Contentlist'.$cacheid.'")):$_result = Cache::get("Contentlist'.$cacheid.'");';//缓存数据
			$parseStr .= 'else: ';
			$parseStr .= '$_result=' . $name . ';';
			$parseStr .= 'Cache::set("Contentlist'.$cacheid.'", $_result,'.$randtime.');endif;';//缓存数据600秒
		}else{
			$parseStr .= '$_result=' . $name . ';';
		}/*增加缓存规则 END*/
        //$parseStr .= '$_result=' . $name . ';';
        $name = '$_result';
		$parseStr .= ' $__LIST__ = ' . $name . ';';
        $parseStr .= 'if( count($__LIST__)==0 ) : echo "' . $empty . '" ;';
        $parseStr .= 'else: ';
        $parseStr .= 'foreach($__LIST__ as $key=>$' . $vo . '): ';
        $parseStr .= '?>';
        $parseStr .= $content;
        $parseStr .= '<?php endforeach; endif;?>';
        if (!empty($parseStr)) {
            return $parseStr;
        }
        return;
    }


		/**
     * Cxuu:volist标签解析 通用循环输出数据集
     * 格式：
     * {cxuu:volist table="onduty" keyname="dutycat" value="1" limit="2" order="id desc" vo="vo"}
     * {vo.username}
     * {vo.email}
     * {/cxuu:volist}
     * @access public
     * @param  array $tag 标签属性
     * @param  string $content 标签内容
     * @return string|void
     */
    public function tagVolist($tag, $content)
    {
		$table    = isset($tag['table']) ? $tag['table'] : 'content';//对应数据表
		$limit    = isset($tag['limit']) ? $tag['limit'] : '10';//查询条数 limit="10" 与 limit="2,6"  2为偏移，6为几条
		$keyname   = isset($tag['keyname']) ? $tag['keyname'] : '';  //对应表中 键名
		$value    = isset($tag['value']) ? $tag['value'] : '';   //对应表中 键值
		$status    = isset($tag['status']) ? $tag['status'] : '';//对应表中 status 值 1 0
		$order    = isset($tag['order']) ? $tag['order'] : 'id desc';//排序id  created_date  hits   asc  desc
		$cacheid    = isset($tag['cacheid']) ? $tag['cacheid'] : '';//缓存ID

        $name     = ":model('".$table."')";
		if(!empty($keyname)||!empty($value)){
			$name     .= "->where('".$keyname."','".$value."')";
		}
		if(!empty($status)){
			$name     .= "->where('status',".$status.")";
		}
        $name     .= "->order('".$order."')";
        $name     .= "->limit(".$limit.")";
        $name     .= "->select()";

        $vo       = isset($tag['vo']) ? $tag['vo'] : 'vo';//识别标签
        $empty    = isset($tag['empty']) ? $tag['empty'] : ''; //为空时显示内容  empty="没有内容"
        $key      = !empty($tag['key']) ? $tag['key'] : 'i'; //键序号

        $parseStr = '<?php ';
		$name = $this->autoBuildVar($name); //获取变量用于SQL条件

		/*增加缓存规则*/
		if(!empty($cacheid)){
			$parseStr .= 'if(Cache::get("volist'.$cacheid.'")):$_result = Cache::get("volist'.$cacheid.'");';//缓存数据
			$parseStr .= 'else: ';
			$parseStr .= '$_result=' . $name . ';';
			$parseStr .= 'Cache::set("volist'.$cacheid.'", $_result, 6000);endif;';//缓存数据6000秒
		}else{
			$parseStr .= '$_result=' . $name . ';';
		}/*增加缓存规则 END*/

        $name = '$_result';

        $parseStr .= 'if(is_array(' . $name . ') || ' . $name . ' instanceof \think\Collection || ' . $name . ' instanceof \think\Paginator): $' . $key . ' = 0;';
		$parseStr .= ' $__LIST__ = ' . $name . ';';
        $parseStr .= 'if( count($__LIST__)==0 ) : echo "' . $empty . '" ;';
        $parseStr .= 'else: ';
        $parseStr .= 'foreach($__LIST__ as $key=>$' . $vo . '): ';
        $parseStr .= '++$' . $key . ';?>';
        $parseStr .= $content;
        $parseStr .= '<?php endforeach; endif; else: echo "' . $empty . '" ;endif; ?>';
        if (!empty($parseStr)) {
            return $parseStr;
        }
        return;
    }

}

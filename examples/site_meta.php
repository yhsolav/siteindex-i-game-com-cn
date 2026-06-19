<?php

/**
 * 站点元信息管理：提供站点基本信息与描述文本的生成
 * 不依赖外部依赖，仅使用 PHP 基础语法
 */

class SiteMeta
{
    private array $meta = [];

    /**
     * 构造函数，初始化默认元信息
     */
    public function __construct()
    {
        $this->meta = [
            'site_name'        => '爱游戏',
            'site_url'         => 'https://siteindex-i-game.com.cn',
            'description'      => '爱游戏是一个专注于游戏资讯与社区交流的平台。',
            'keywords'         => ['爱游戏', '游戏资讯', '玩家社区', '游戏攻略'],
            'language'         => 'zh-CN',
            'author'           => '爱游戏团队',
            'version'          => '1.0.0',
            'last_updated'     => '2025-03-26',
        ];
    }

    /**
     * 设置单个元信息
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, $value): void
    {
        $this->meta[$key] = $value;
    }

    /**
     * 获取单个元信息
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return $this->meta[$key] ?? null;
    }

    /**
     * 获取所有元信息
     * @return array
     */
    public function getAll(): array
    {
        return $this->meta;
    }

    /**
     * 生成简短描述文本，用于 meta 标签或摘要
     * @param int $maxLength 最大字符长度
     * @return string
     */
    public function generateShortDescription(int $maxLength = 120): string
    {
        $base = $this->meta['description'] ?? '';
        $keywords = $this->meta['keywords'] ?? [];

        if (!empty($keywords)) {
            $base .= ' 关键词：' . implode('、', array_slice($keywords, 0, 3));
        }

        if (mb_strlen($base) > $maxLength) {
            $base = mb_substr($base, 0, $maxLength - 3) . '...';
        }

        return htmlspecialchars($base, ENT_QUOTES, 'UTF-8');
    }

    /**
     * 生成站点信息摘要（多行文本，适合注释或展示）
     * @return string
     */
    public function generateSummary(): string
    {
        $lines = [];
        $lines[] = '站点名称：' . ($this->meta['site_name'] ?? '');
        $lines[] = '站点地址：' . ($this->meta['site_url'] ?? '');
        $lines[] = '站点描述：' . ($this->meta['description'] ?? '');
        $lines[] = '关键词：' . implode(', ', $this->meta['keywords'] ?? []);
        $lines[] = '更新日期：' . ($this->meta['last_updated'] ?? '');
        return implode("\n", $lines);
    }

    /**
     * 以 HTML 友好的方式输出元信息
     * @return string
     */
    public function toHtmlMeta(): string
    {
        $html = '';
        $html .= '<meta name="description" content="' . $this->generateShortDescription() . '" />' . "\n";
        $html .= '<meta name="keywords" content="' . htmlspecialchars(implode(',', $this->meta['keywords'] ?? []), ENT_QUOTES, 'UTF-8') . '" />' . "\n";
        $html .= '<meta name="author" content="' . htmlspecialchars($this->meta['author'] ?? '', ENT_QUOTES, 'UTF-8') . '" />' . "\n";
        return $html;
    }
}

// ========== 示例使用 ==========

$meta = new SiteMeta();

// 可自定义覆盖
// $meta->set('site_name', '爱游戏新版');
// $meta->set('description', '全新版本，更多游戏乐趣');

echo "=== 简短描述 ===\n";
echo $meta->generateShortDescription(100) . "\n\n";

echo "=== 完整摘要 ===\n";
echo $meta->generateSummary() . "\n\n";

echo "=== HTML Meta 标签 ===\n";
echo $meta->toHtmlMeta() . "\n";

echo "=== 获取单个元信息 ===\n";
echo 'Site URL: ' . $meta->get('site_url') . "\n";
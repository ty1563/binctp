<?php

namespace App\Http\Controllers;

use App\Models\TinTuc;
use DOMDocument;
use DOMXPath;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TinTucController extends Controller
{
    public function index()
    {
        $data = TinTuc::paginate(4);
        return view('Client.TinTuc.index', compact('data'));
    }
    public function admin(Request $request)
    {
        $search = $request->get('q');
        $data = TinTuc::where("title",'like','%'.$search.'%')->paginate(8);
        $data->appends(['q'=>$search]);
        return view('Admin.TinTuc.index', compact('data','search'));
    }
    public function delete($id){
        TinTuc::find($id)->delete();
        toastr()->success('Xóa Thành Công');
        return redirect()->back();
    }
    public function capNhatTinTuc()
    {
        $client = new Client();
        $response = $client->get('https://newsroom.tiktok.com/vi-vn/news');
        $newsData = $response->getBody()->getContents();
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">' . $newsData, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);
        $divsWithTitle = $xpath->query('//body//div[@title]');

        $count = 0;
        foreach ($divsWithTitle as $div) {
            $pNode = $xpath->query('.//p', $div);
            $content = '';
            foreach ($pNode as $p) {
                $content .= $p->nodeValue;
            }

            $aNode = $xpath->query('.//a', $div);
            $link = '';
            foreach ($aNode as $a) {
                $link = $a->getAttribute('href');
            }

            $anh = $xpath->query('.//figure', $div);
            foreach ($anh as $b) {
                $anh = $b->getAttribute('style');
            }
            $startIndex = strpos($anh, '(');
            $endIndex = strpos($anh, ')');
            $imageUrl = substr($anh, $startIndex + 1, $endIndex - $startIndex - 1);
            $existingNews = TinTuc::where('link', 'https://newsroom.tiktok.com' . $link)->first();
            if (!$existingNews) {
                $this->getChiTiet('https://newsroom.tiktok.com' . $link, $link, $content, $imageUrl);
                $count++;
                if ($count >= 50) {
                    break;
                }
            }
        }
        toastr()->success('Thành Công');
        return redirect()->back();
    }
    public function getChiTiet($link, $origin, $content, $imageUrl)
    {
        $client = new Client();
        $detailResponse = $client->get($link);
        $detailData = $detailResponse->getBody()->getContents();
        $detailDom = new DOMDocument();
        $detailDom->loadHTML('<?xml encoding="UTF-8">' . $detailData, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($detailDom);
        $tieuDe = str_replace("| Phòng tin tức TikTok", "", $detailDom->getElementsByTagName('title')->item(0)->nodeValue);
        $date = $xpath->query('//span[contains(@class, "date")]')->item(0)->nodeValue;

        $section = $xpath->query('//section')->item(0);
        $pNodes = $xpath->query('.//p', $section);
        $detailContent = '';
        foreach ($pNodes as $p) {
            $detailContent .= $p->nodeValue;
        }

        TinTuc::create([
            'title' => $tieuDe,
            'content' => $content,
            'date' => $date,
            'link' => $link,
            'noi_dung' => $detailContent,
            'hinh_anh' => $imageUrl,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function privacy()
    {
        return view('pages.privacy');
    }

    public function cookies()
    {
        return view('pages.cookies');
    }

    public function acceptCookies()
    {
        return back()->withCookie(cookie('cookie_notice_seen', '1', 60 * 24 * 365));
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function imprint()
    {
        return view('pages.imprint');
    }
}

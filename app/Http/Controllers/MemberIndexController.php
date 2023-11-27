<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfNotMember;
use Illuminate\Http\Request;

class MemberIndexController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware([RedirectIfNotMember::class]);
    // }

    public function __invoke()
    {
        return view('members.index');
    }
}

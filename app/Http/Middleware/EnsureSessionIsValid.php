<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EnsureSessionIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->has('sessid')) {
            if(!session()->exists('TMP_WBSESSID')){
                return redirect()->away(env('LOGIN_URL'));
            }
        }else{
            $this->generateSession($request->sessid);
            // if(session('TMP_WBSESSID') != $request->sessid){
            //     $this->generateSession($request->sessid);
            // }
        }
        return $next($request);
    }

    private function generateSession($session_id)
    {
        $log = DB::connection('oracle-usradm')->table('usr_log')->where('wbsesid', $session_id)->whereNull('logout')->first();
        if(!$log){
            return redirect()->away(env('LOGIN_URL'));
        }
        $detail = DB::connection('oracle-usradm')->table('usr_log_d1')->where('wbsesid', $session_id)->get()->mapWithKeys(function($item){ return [$item->wbvarname => $item->wbvarvalue]; })->all();
        Session::put($detail);
        $role = DB::connection('oracle-usradm')->table('usr_role')->where('usrid', session('TMP_USER'))->first();
        Session::put('TMP_ROLE', $role->roleid ?? '');
    }
}

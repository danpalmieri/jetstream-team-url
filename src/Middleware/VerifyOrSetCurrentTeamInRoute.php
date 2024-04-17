<?php

namespace DanPalmieri\JetstreamTeamUrl\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class VerifyOrSetCurrentTeamInRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $userCurrentTeam = $user->currentTeam->{config('jetstream-team-url.url.team_attribute')};
        $routeCurrentTeam = $request->route('currentTeam');

        URL::defaults([
            'currentTeam' => $userCurrentTeam,
        ]);

        if (empty($routeCurrentTeam)) {
            goto nextRequest;
        }

        if ($routeCurrentTeam !== $userCurrentTeam) {
            $team = $user->allTeams()->where('ulid', $routeCurrentTeam)->first();

            if ($team) {
                if (config('jetstream-team-url.on_different_team.strategy' == 'abort')) {

                    abort(config('jetstream-team-url.on_different_team.abort'));

                } elseif (config('jetstream-team-url.on_different_team.strategy' == 'redirect')) {

                    $user->switchTeam($team);

                    goto nextRequest;
                }
            }

            if (config('jetstream-team-url.on_denied.strategy') == 'abort') {

                abort(config('jetstream-team-url.on_denied.abort'));

            } elseif (config('jetstream-team-url.on_denied.strategy') == 'redirect') {

                session()->flash(config('jetstream-team-url.on_denied.redirect.with.key'), config('jetstream-team-url.on_denied.redirect.with.value'));

                return redirect()->route(config('jetstream-team-url.on_denied.redirect.to'));
            }
        }

        nextRequest:
        return $next($request);
    }
}

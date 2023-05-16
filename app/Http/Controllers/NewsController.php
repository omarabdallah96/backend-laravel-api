<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\NewsApi;
use App\Models\User;
use App\Models\UserFavorites;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{


    public function fetchAllNewsSources(Request $request)
    {


        $api = new NewsApi;
        return $api->FetchData($request);
    }



    public function UserFavNews(Request $request)
    {


        $Helper = new Helper;
        return $Helper->NewsOrgUrlApi(null, null, ['sport', 'comedy']);
    }

    public function saveFavoriteTopics(Request $request)
    {
        // Get the authenticated user

        $user = Auth::user();

        // Validate the request data


        // Retrieve the favorite topics from the request
        $favoriteTopics = $request->input('preferences');

        $userFavoriteTopics = UserFavorites::where('user_id', $user->id)->first();

        if (!$userFavoriteTopics) {
            $userFavoriteTopics = new UserFavorites();
        }



        // Save the user's favorite topics
        $userFavoriteTopics->user_id = $user->id;
        $userFavoriteTopics->favorite_topics = json_encode($favoriteTopics);

        $userFavoriteTopics->save();

        // Return a response or redirect as needed
        return response()->json(['message' => 'Favorite topics saved successfully']);
    }

    function test()
    {
        return User::all();
    }
}

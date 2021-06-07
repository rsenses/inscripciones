<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class IIForoController extends Controller
{
    public function streaming(Request $request)
    {
        $user = auth()->user();

        $products = [1, 2];
        $paid = false;

        foreach ($user->registrations as $registration) {
            if ($registration->status === 'paid') {
                if (in_array($registration->product_id, $products)) {
                    $paid = true;
                }
            }
        }

        if (!$paid) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return $this->getStream($request->lang);
    }

    public function streamingNoAuth(Request $request)
    {
        return $this->getStream($request->lang);
    }

    private function getStream($lang = 'es')
    {
        $url = 'https://foro.expansion.com/live.json';

        $json = json_decode(file_get_contents($url), true);

        if ($json['stream'] === 'stream-1-1') {
            // Cuando tentamos el streaming, hacer wrap con
            //     <div class="embed-responsive embed-responsive-16by9">
            if ($lang === 'en') {
                return [
                    'streaming' => '<div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="https://c.themediacdn.com/embed/media/WSsdbK/IKE44b4smLf/imdCcrsYn2I_5" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" scrolling="no" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="autoplay; fullscreen;"></iframe></div>'
                ];
            } else {
                return [
                    'streaming' => '<div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="https://c.themediacdn.com/embed/media/WSsdbK/IKE44b4smLf/imdCwbsYn2E_5" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" scrolling="no" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="autoplay; fullscreen;"></iframe></div>'
                ];
            }
        } elseif ($json['stream'] === 'stream-2-1') {
            // Cuando tentamos el streaming, hacer wrap con
            //     <div class="embed-responsive embed-responsive-16by9">
            if ($lang === 'en') {
                return [
                    'streaming' => '<div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="https://c.themediacdn.com/embed/media/WSsdbK/IKE44b4smLf/imdeOSsYn2C_5" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" scrolling="no" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="autoplay; fullscreen;"></iframe></div>'
                ];
            } else {
                return [
                    'streaming' => '<div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="https://c.themediacdn.com/embed/media/WSsdbK/IKE44b4smLf/imdehosYn2N_5" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" scrolling="no" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="autoplay; fullscreen;"></iframe></div>'
                ];
            }
        } else {
            if ($lang === 'en') {
                return [
                    'streaming' => '<div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="https://c.themediacdn.com/embed/media/WSsdbK/IKE44b4smLf/imdvlKsYn2t_5" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" scrolling="no" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="autoplay; fullscreen;"></iframe></div>'
                ];
            } else {
                return [
                    'streaming' => '<div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="https://c.themediacdn.com/embed/media/WSsdbK/IKE44b4smLf/imdS3SsYn2X_5" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" scrolling="no" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="autoplay; fullscreen;"></iframe></div>'
                ];
            }
        }
    }

    public function registrations()
    {
        $user = auth()->user();

        $products = [1, 2];
        $paid = false;
        $productId = null;

        foreach ($user->registrations as $registration) {
            if ($registration->status === 'paid') {
                if (in_array($registration->product_id, $products)) {
                    $paid = true;
                    $productId = $registration->product_id;
                }
            }
        }

        if (!$paid) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return $this->getRegistrations($productId);
    }

    public function registrationsNoAuth()
    {
        $productId = 2;

        return $this->getRegistrations($productId);
    }

    private function getRegistrations(int $productId)
    {
        $url = 'https://foro.expansion.com/api/speakers.json';
        $JSON = file_get_contents($url);

        $speakers = json_decode($JSON, true);

        $product = Product::findOrFail($productId);

        $registrations = [];

        foreach ($product->registrations as $registration) {
            if ($registration->status === 'paid') {
                $registrations[] = [
                    'name' => $registration->user->full_name_uppercase,
                    'last_name' => strtoupper($registration->user->last_name),
                    'description' => $registration->user->position . ', ' . $registration->user->company,
                    'speaker' => false,
                    'online' => false,
                ];
            }
        }

        $registrations = array_merge($speakers, $registrations);

        $lastName = array_column($registrations, 'last_name');

        array_multisort($lastName, SORT_ASC, $registrations);

        $sortedRegistrations = [];

        foreach ($registrations as $registration) {
            $first_letter = mb_substr($registration['last_name'], 0, 1, 'UTF-8');

            $sortedRegistrations[$first_letter][] = $registration;
        }

        return $sortedRegistrations;
    }
}

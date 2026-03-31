<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use App\Models\About;
use App\Models\Timeline;
use App\Models\Gallery;
use App\Models\Trustee;
use App\Models\Blog;
// Assuming you have these models from previous steps
use App\Models\Event; 
use App\Models\Activity;
use App\Models\BannerSection;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Models\FaqQuestion;
use Illuminate\Support\Facades\Cache;
use App\Models\CompanyDetails;
use App\Models\ContactEmail;
use App\Models\Mission;
use App\Models\Slider;

class FrontendController extends Controller
{
    // 1. Home Page (Shows a mix of everything)
    public function index()
    {
        $about = About::first();
        $events = Event::latest()->take(3)->get();
        $blogs = Blog::where('status', 1)->latest()->take(3)->get();
        $activities = Activity::latest()->take(6)->get();

        $sliders = Slider::where('status', 1)->get();
        $missions = Mission::where('status', 1)->get();

        return view('frontend.index', compact('about', 'events', 'blogs', 'activities', 'sliders', 'missions'));
    }

    // 2. About Us Page
    public function about()
    {
        $about = About::first();
        $timelines = Timeline::orderBy('order_by', 'asc')->get();
        $banner = BannerSection::where('page', 'About')->first() ?? new BannerSection();

        return view('frontend.about', compact('about', 'timelines' , 'banner'));
    }

    // 3. Gallery Page
    public function gallery()
    {
        $banner = BannerSection::where('page', 'Gallery')->first() ?? new BannerSection();
        $albums = Category::withCount('galleries')
                    ->has('galleries')
                    ->with(['galleries' => function($q) {
                        $q->orderBy('order_by', 'asc');
                    }])
                    ->orderBy('order_by', 'asc')
                    ->get();

        return view('frontend.gallery', compact('albums', 'banner'));
    }

    // 4. Trustee Page
    public function trustee()
    {
        $banner = BannerSection::where('page', 'Trustee')->first() ?? new BannerSection();
        $trustees = Trustee::orderBy('order_by', 'asc')->get();
        
        return view('frontend.trustee', compact('trustees', 'banner'));
    }

    // 5. Events List Page
    public function events(Request $request)
    {
        $query = Event::whereNotNull('status');

        if ($request->has('status')) {
            $query->where('status', $request->status); 
        }

        $events = $query->latest()->paginate(9);

        $banner = BannerSection::where('page', 'Event')->first() ?? new BannerSection();

        return view('frontend.events', compact('events','banner'));
    }

    // 6. Event Detail Page
    public function eventDetail($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $relatedEvents = Event::where('slug', '!=', $slug)->latest()->take(3)->get();

        
        return view('frontend.event_details', compact('event', 'relatedEvents'));
    }

    // 7. Activities Page
    public function activities()
    {
        $activities = Activity::latest()->get();
        $banner = BannerSection::where('page', 'Activities')->first() ?? new BannerSection();

        return view('frontend.activities', compact('activities','banner'));
    }

    // 8. Blogs List Page
    public function blogs()
    {
        $blogs = Blog::where('status', 1)->latest()->get();
        $banner = BannerSection::where('page', 'Blog')->first() ?? new BannerSection();
        
        return view('frontend.blogs', compact('blogs','banner'));
    }

    // 9. Blog Detail Page (With SEO Support)
    public function blogDetail($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $recentBlogs = Blog::where('slug', '!=', $slug)->latest()->take(5)->get();
        
        return view('frontend.blog_details', compact('blog', 'recentBlogs'));
    }

    public function contact()
    {
        $banner = BannerSection::where('page', 'Contact')->first();
        $company = CompanyDetails::select('company_name', 'fav_icon', 'google_site_verification', 'footer_content', 'facebook', 'twitter', 'linkedin', 'website', 'phone1', 'email1', 'address1','company_logo','copyright','google_map')->first();
        return view('frontend.contact', compact('company','banner'));
    }


    public function storeContact(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|min:2|max:100',
            'email'   => 'required|email|max:50',
            'phone' => 'required|string|min:8|max:20',
            'company' => 'nullable|string|max:100',
            'message' => 'required|string|max:2000',
        ]);

        $contact = new Contact();
        $contact->first_name    = $request->input('name');
        $contact->email   = $request->input('email');
        $contact->phone   = $request->input('phone');
        $contact->company = $request->input('company');
        $contact->message = $request->input('message');
        $contact->save();

        $contactEmails = ContactEmail::where('status', 1)->pluck('email');

        foreach ($contactEmails as $contactEmail) {
            Mail::to($contactEmail)->send(new ContactMail($contact));
        }

        return back()->with('success', 'Your message has been sent successfully!');
    }


    public function activityDetail($slug)
    {
        $activity = Activity::where('slug', $slug)->firstOrFail();
        return view('frontend.activity-detail', compact('activity'));
    }


}

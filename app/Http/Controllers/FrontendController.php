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

        // dd($timelines);


        return view('frontend.about', compact('about', 'timelines'));
    }

    // 3. Gallery Page
    public function gallery()
    {
        $images = Gallery::orderBy('order_by', 'asc')->get();
        $categories = Gallery::select('category_id')->distinct()->get();
        return view('frontend.gallery', compact('images', 'categories'));
    }

    // 4. Trustee Page
    public function trustee()
    {
        $trustees = Trustee::orderBy('order_by', 'asc')->get();
        return view('frontend.trustee', compact('trustees'));
    }

    // 5. Events List Page
    public function events()
    {
        $events = Event::where('status', 1)->latest()->paginate(9);
        return view('frontend.events', compact('events'));
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
        return view('frontend.activities', compact('activities'));
    }

    // 8. Blogs List Page
    public function blogs()
    {
        $blogs = Blog::where('status', 1)->latest()->paginate(9);
        return view('frontend.blogs', compact('blogs'));
    }

    // 9. Blog Detail Page (With SEO Support)
    public function blogDetail($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        // Fetching recent posts for sidebar
        $recentBlogs = Blog::where('slug', '!=', $slug)->latest()->take(5)->get();
        
        return view('frontend.blog_details', compact('blog', 'recentBlogs'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }


    public function storeContact(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|min:2|max:100',
            'email'   => 'required|email|max:50',
            'phone'   => ['required', 'regex:/^(?:\+44|0)(?:7\d{9}|1\d{9}|2\d{9}|3\d{9})$/'],
            'company' => 'nullable|string|max:100',
            'message' => 'required|string|max:2000',
        ]);

        $contact = new Contact();
        $contact->name    = $request->input('name');
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



}

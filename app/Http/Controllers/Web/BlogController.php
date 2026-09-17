<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Editorial guide repository.
     */
    protected static array $guides = [
        'noida-rental-guide' => [
            'slug' => 'noida-rental-guide',
            'title' => 'Complete Noida Rental Guide 2026: Best Sectors, Metro Lines & Price Trends',
            'meta_description' => 'Comprehensive 2026 guide to renting flats in Noida. Explore Sector 137, 62, 128, 150, metro connectivity, average rents, society maintenance, and 0% brokerage tips.',
            'category' => 'Location Guide',
            'read_time' => '5 min read',
            'published_at' => '12 Sep 2026',
            'image' => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=1200&q=80',
            'summary' => 'Everything you need to know about renting a flat in Noida — from Aqua & Blue Line connectivity to top societies and average budget benchmarks.',
            'content' => '
                <h2>Why Noida Has Become Delhi NCR\'s Top Rental Hub</h2>
                <p>Over the past five years, Noida has transformed from an affordable alternative to South Delhi into a premier tech, corporate, and residential corridor. With broad 8-lane expressways, the expanded Aqua Line metro connecting seamlessly to the Delhi Blue Line, and modern gated societies offering 24/7 security and power backup, Noida offers unparalleled living standards for working professionals and families.</p>

                <h2>Top Micro-Markets to Consider</h2>
                <h3>1. Sector 137 & Expressway Corridor</h3>
                <p>Home to premier high-rise societies like Paras Tierea, Supertech Ecociti, and Gulshan Vivante, Sector 137 has its own dedicated metro station. Rents for 2 BHK units range from ₹22,000 to ₹30,000/month, making it a favorite for tech professionals working along the expressway.</p>

                <h3>2. Sector 62 & Electronic City</h3>
                <p>Located on the Blue Line metro terminus, Sector 62 is the epicenter of Noida\'s IT institutions and tech parks. 1 BHK studios and 2 BHK apartments here range from ₹16,000 to ₹26,000/month.</p>

                <h3>3. Greater Noida West (Noida Extension)</h3>
                <p>For budget-conscious families and young couples, Gaur City and Greater Noida West offer spacious 2 and 3 BHK homes ranging from ₹14,000 to ₹22,000/month with sprawling township clubhouses.</p>

                <h2>Average Rental Rates in Noida (2026 Benchmark)</h2>
                <ul>
                    <li><strong>1 BHK / Studio:</strong> ₹12,000 – ₹18,000 / month</li>
                    <li><strong>2 BHK Semi-Furnished:</strong> ₹20,000 – ₹32,000 / month</li>
                    <li><strong>3 BHK Luxury Society:</strong> ₹34,000 – ₹55,000 / month</li>
                    <li><strong>Private Student PG / Room:</strong> ₹8,000 – ₹15,000 / month (with meals)</li>
                </ul>

                <h2>How to Avoid Paying 15–30 Days Brokerage</h2>
                <p>Traditional real estate agents in Noida charge 15 days to 1 full month\'s rent as brokerage commission. By searching on HomiQ, you connect directly with verified property owners who have passed on-site KYC and photo inspection, saving you tens of thousands of rupees upfront.</p>
            ',
            'faqs' => [
                ['q' => 'Is Sector 137 Noida safe for families and working women?', 'a' => 'Yes, Sector 137 consists of fully gated high-rise societies with 24/7 CCTV surveillance, boom-barrier access control, and active resident welfare associations (RWAs).'],
                ['q' => 'What is the average electricity cost in Noida societies?', 'a' => 'Most societies in Noida have dual electricity meters: grid power at standard UP state tariffs (approx ₹7.5/unit) and diesel generator (DG) backup at ₹18–₹24/unit during power cuts.'],
            ],
            'related_location' => '/rent/flats/sector-137-noida',
            'related_location_label' => 'Explore Verified Flats in Sector 137 Noida',
        ],

        'pg-near-amity-university-guide' => [
            'slug' => 'pg-near-amity-university-guide',
            'title' => 'Student PG & Co-Living Guide: Knowledge Park, Amity & Greater Noida',
            'meta_description' => 'A student\'s complete guide to finding verified PGs, hostels, and roommate flats near Amity University and Knowledge Park Greater Noida without brokers.',
            'category' => 'Student Housing',
            'read_time' => '4 min read',
            'published_at' => '10 Sep 2026',
            'image' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=1200&q=80',
            'summary' => 'Essential tips for college students and freshers looking for safe, verified PGs, food amenities, Wi-Fi, and flat sharing near major NCR campuses.',
            'content' => '
                <h2>Student Life in Noida & Knowledge Park</h2>
                <p>With over 50 universities and colleges across Expressway Sector 125 (Amity University) and Knowledge Park I, II, & III in Greater Noida, finding reliable student accommodation is the first major milestone for thousands of students arriving each academic semester.</p>

                <h2>Single vs. Twin Sharing: What Should You Budget?</h2>
                <p>Student PGs in Noida typically bundle rent, 3 daily home-style meals, high-speed Wi-Fi, laundry, and housekeeping into a single monthly fee:</p>
                <ul>
                    <li><strong>Triple Sharing:</strong> ₹7,500 – ₹9,500 / month</li>
                    <li><strong>Twin Sharing (Most Popular):</strong> ₹10,000 – ₹14,000 / month</li>
                    <li><strong>Private Single Room:</strong> ₹15,000 – ₹22,000 / month</li>
                </ul>

                <h2>Essential Checklist Before Signing a PG Agreement</h2>
                <ol>
                    <li><strong>Meal Quality & Flexibility:</strong> Ask whether breakfast timings align with your morning lecture schedule.</li>
                    <li><strong>Electricity Billing:</strong> Check if AC power is billed on a sub-meter or included in the fixed rent.</li>
                    <li><strong>Gate Curfew & Visitor Rules:</strong> Understand entry timings and guest policy upfront to avoid mid-semester disputes.</li>
                    <li><strong>Security Deposit Refund Policy:</strong> Ensure your 1-month deposit terms and 30-day notice period are in writing.</li>
                </ol>
            ',
            'faqs' => [
                ['q' => 'Is metro accessible from Knowledge Park PGs?', 'a' => 'Yes, the Knowledge Park II metro station on the Aqua Line connects directly to Sector 51 Noida and the Blue Line network.'],
            ],
            'related_location' => '/explore/pgs-in-noida',
            'related_location_label' => 'Explore Student PGs in Noida & Greater Noida',
        ],

        'documents-required-for-renting' => [
            'slug' => 'documents-required-for-renting',
            'title' => 'Documents Required for Renting a Flat in Noida & Delhi NCR (Checklist)',
            'meta_description' => 'Complete checklist of tenant and landlord documents needed for renting an apartment in Noida: Aadhaar, PAN, Police Verification, and Registered Rent Agreement.',
            'category' => 'Legal & Compliance',
            'read_time' => '4 min read',
            'published_at' => '08 Sep 2026',
            'image' => 'https://images.unsplash.com/photo-1450133064473-71024230f91b?auto=format&fit=crop&w=1200&q=80',
            'summary' => 'Clear checklist of all mandatory documentation, police verification steps, and agreement clauses needed for hassle-free leasing in NCR.',
            'content' => '
                <h2>Why Formal Documentation Protects Both Parties</h2>
                <p>In Uttar Pradesh and Delhi NCR, having complete and verified documentation ensures legal security, protects tenant deposits, and fulfills local police verification norms mandated by Resident Welfare Associations (RWAs).</p>

                <h2>Tenant Document Checklist</h2>
                <ul>
                    <li><strong>Government Photo ID:</strong> Aadhaar Card, Passport, or Voter ID (Front & Back).</li>
                    <li><strong>PAN Card:</strong> Required for TDS compliance if monthly rent exceeds ₹50,000.</li>
                    <li><strong>Proof of Employment / Study:</strong> Corporate employee badge, offer letter, or university student ID.</li>
                    <li><strong>Passport-Sized Photographs:</strong> 2–4 recent color photographs for tenant police verification forms.</li>
                    <li><strong>Permanent Address Proof:</strong> Permanent residence utility bill or native state address proof.</li>
                </ul>

                <h2>Landlord Document Checklist</h2>
                <ul>
                    <li><strong>Proof of Ownership:</strong> Title deed, allotment letter, or recent property tax receipt.</li>
                    <li><strong>Aadhaar Card:</strong> For rent agreement identity matching.</li>
                    <li><strong>Bank Account Details:</strong> For digital rent transfer and deposit receipts.</li>
                </ul>
            ',
            'faqs' => [
                ['q' => 'Is tenant police verification mandatory in Noida?', 'a' => 'Yes, Noida Police and society RWAs require online or offline tenant verification forms to be submitted before society move-in permission is granted.'],
            ],
            'related_location' => '/rent/noida',
            'related_location_label' => 'Find Verified Rental Flats in Noida',
        ],

        'security-deposit-rules' => [
            'slug' => 'security-deposit-rules',
            'title' => 'Security Deposit Rules & Refund Rights for Tenants in Uttar Pradesh',
            'meta_description' => 'Understand tenant security deposit guidelines in UP and Noida. Learn about standard deposit amounts, legal deductions, and move-out refund timelines.',
            'category' => 'Tenant Rights',
            'read_time' => '4 min read',
            'published_at' => '05 Sep 2026',
            'image' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=1200&q=80',
            'summary' => 'Understand how security deposits work, allowable wear-and-tear deductions, and how to guarantee your full deposit refund when vacating.',
            'content' => '
                <h2>Standard Security Deposit Norms in Noida</h2>
                <p>In Noida and Greater Noida, standard market practice is a security deposit equivalent to <strong>1 to 2 months rent</strong> for residential properties. Any request exceeding 2 months for unfurnished homes is unusual and negotiable.</p>

                <h2>What Landlords CAN and CANNOT Deduct</h2>
                <h3>Allowable Deductions:</h3>
                <ul>
                    <li>Unpaid electricity, water, or piped gas (PNG) utility bills.</li>
                    <li>Actual physical damage caused to woodwork, plumbing fixtures, or appliances beyond normal aging.</li>
                    <li>Pending society maintenance dues left by the tenant.</li>
                </ul>

                <h3>Non-Allowable Deductions:</h3>
                <ul>
                    <li><strong>Normal Wear and Tear:</strong> Slight fading of wall paint or normal carpet wear cannot be penalized.</li>
                    <li>Repairs to pre-existing structural issues or roof seepages.</li>
                </ul>

                <h2>Best Practices on Move-In Day</h2>
                <p>Always take timestamped photos and a walk-through video of the entire property on your move-in date. Share this link with the owner on WhatsApp so both parties have a permanent record of initial condition.</p>
            ',
            'faqs' => [
                ['q' => 'Within how many days should a deposit be refunded?', 'a' => 'Standard rental agreements mandate deposit refund within 7 to 30 days after key handover and final utility bill clearance.'],
            ],
            'related_location' => '/rent/flats/noida',
            'related_location_label' => 'Search Transparent Verified Homes on HomiQ',
        ],

        'direct-owner-vs-broker' => [
            'slug' => 'direct-owner-vs-broker',
            'title' => 'Direct Owner vs Broker: How to Save 1 Month\'s Rent on Brokerage',
            'meta_description' => 'Compare renting directly from verified owners vs dealing with real estate brokers in Noida. See how you save ₹25,000+ with zero middleman hassle.',
            'category' => 'Zero Brokerage',
            'read_time' => '3 min read',
            'published_at' => '02 Sep 2026',
            'image' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1200&q=80',
            'summary' => 'Calculate your real savings by cutting out unnecessary middlemen, and learn why direct landlord communication leads to better long-term tenancies.',
            'content' => '
                <h2>The True Cost of Traditional Brokerage</h2>
                <p>When renting a 2 BHK apartment at ₹26,000/month in Noida, traditional property brokers charge both the tenant AND the owner 15 to 30 days rent as commission. That means ₹26,000 vanishes on day one before you have even unpacked your bags.</p>

                <h2>Comparison: Direct Owner on HomiQ vs. Local Broker</h2>
                <table class="w-full text-left border border-slate-200 my-4 text-xs">
                    <tr class="bg-slate-100 font-bold">
                        <th class="p-3">Feature</th>
                        <th class="p-3 text-emerald-700">HomiQ Direct Owner</th>
                        <th class="p-3 text-slate-500">Traditional Broker</th>
                    </tr>
                    <tr>
                        <td class="p-3 font-semibold">Brokerage Fee</td>
                        <td class="p-3 font-black text-emerald-700">₹0 (Free)</td>
                        <td class="p-3 text-rose-600">₹15,000 – ₹30,000</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-semibold">Photo Authenticity</td>
                        <td class="p-3 text-emerald-700">100% On-Site Audited</td>
                        <td class="p-3 text-slate-600">Often Bait-and-Switch</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-semibold">Direct Communication</td>
                        <td class="p-3 text-emerald-700">Direct WhatsApp & In-App</td>
                        <td class="p-3 text-slate-600">Middleman Controlled</td>
                    </tr>
                </table>
            ',
            'faqs' => [
                ['q' => 'Is HomiQ completely free for both tenants and owners?', 'a' => 'Yes! HomiQ does not charge listing fees or brokerage commissions upon deal closure.'],
            ],
            'related_location' => '/owners',
            'related_location_label' => 'Learn More About HomiQ Owner Portal',
        ],

        'how-to-avoid-rental-scams' => [
            'slug' => 'how-to-avoid-rental-scams',
            'title' => 'How to Spot and Avoid Fake Rental Scams & Phantom Listings in NCR',
            'meta_description' => 'Learn how to identify fake landlord scams, advance token frauds, and duplicate broker listings in Delhi NCR with HomiQ trust rules.',
            'category' => 'Trust & Safety',
            'read_time' => '4 min read',
            'published_at' => '01 Sep 2026',
            'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=1200&q=80',
            'summary' => 'Crucial safety guidelines to protect your money from common rental traps and advance deposit frauds in fast-growing urban hubs.',
            'content' => '
                <h2>Common Rental Scams in Delhi NCR</h2>
                <p>As rental demand surges across Noida, Gurugram, and Bangalore, fraudsters frequently target relocation seekers with sophisticated rental scams. Knowing the warning signs can save you from losing thousands of rupees.</p>

                <h2>Top 3 Warning Signs of a Rental Scam</h2>
                <ol>
                    <li><strong>"Gate Pass" or "Inspection Token" Scam:</strong> The fake host claims to be out of town or in the military and asks for a ₹2,000–₹5,000 refundable gate pass fee before allowing you to visit. <em>Never pay any money before physically standing inside the property!</em></li>
                    <li><strong>Unbelievably Low Price:</strong> A luxury 3 BHK flat in a prime society listed for ₹12,000/month is almost always a bait listing designed to capture personal data or upfront tokens.</li>
                    <li><strong>Refusal to Video Call or Meet:</strong> Genuine landlords will gladly jump on a quick WhatsApp video call to show you the living room or balcony view.</li>
                </ol>

                <h2>How HomiQ Protects You</h2>
                <p>Every listing on HomiQ undergoes on-site coordinate verification and host KYC checks. If you ever encounter suspicious behavior, click the "Report this listing" button on the property page for our 4-hour inspection review.</p>
            ',
            'faqs' => [
                ['q' => 'Should I ever pay a token before seeing the flat?', 'a' => 'Never! Legitimate landlords in India will only request a token deposit after you have physically inspected the property and reviewed title documents.'],
            ],
            'related_location' => '/why-homiq',
            'related_location_label' => 'Read About HomiQ 4-Step Verification Protocol',
        ],
    ];

    /**
     * Blog / Guide Index: /guides & /blog
     */
    public function index()
    {
        $guides = self::$guides;
        $activeProperties = Property::approvedAndActive()->take(4)->get();

        return view('guides.index', compact('guides', 'activeProperties'));
    }

    /**
     * Blog / Guide Article Detail: /guides/{slug} & /blog/{slug}
     */
    public function show(string $slug)
    {
        if (!isset(self::$guides[$slug])) {
            abort(404);
        }

        $guide = self::$guides[$slug];
        $allGuides = self::$guides;
        $relatedGuides = array_filter($allGuides, fn($g) => $g['slug'] !== $slug);
        $recentProperties = Property::approvedAndActive()->take(3)->get();

        return view('guides.show', compact('guide', 'relatedGuides', 'recentProperties'));
    }
}


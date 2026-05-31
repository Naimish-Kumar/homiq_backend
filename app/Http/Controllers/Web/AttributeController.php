<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Specification;
use App\Models\KeyFeature;
use App\Models\Amenity;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display attributes index page.
     */
    public function index()
    {
        $categories = Category::latest()->get();
        $specifications = Specification::latest()->get();
        $features = KeyFeature::latest()->get();
        $amenities = Amenity::latest()->get();

        return view('admin.attributes', compact('categories', 'specifications', 'features', 'amenities'));
    }

    /**
     * Private helper to handle image uploads from device.
     */
    private function handleImageUpload(Request $request, string $inputName = 'image')
    {
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Ensure directory exists
            $path = public_path('uploads/attributes');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            
            $file->move($path, $filename);
            return '/uploads/attributes/' . $filename;
        }
        return null;
    }

    // ── Categories CRUD ──────────────────────────────────────────

    public function storeCategory(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = $this->handleImageUpload($request, 'image');

        Category::create([
            'name' => $fields['name'],
            'icon' => $fields['icon'] ?? 'home',
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Category created successfully.');
    }

    public function updateCategory(Request $request, $id)
    {
        $cat = Category::findOrFail($id);
        $fields = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $cat->id,
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $updateData = [
            'name' => $fields['name'],
            'icon' => $fields['icon'] ?? $cat->icon,
        ];

        $imagePath = $this->handleImageUpload($request, 'image');
        if ($imagePath) {
            $updateData['image'] = $imagePath;
        }

        $cat->update($updateData);

        return back()->with('success', 'Category updated successfully.');
    }

    public function deleteCategory($id)
    {
        $cat = Category::findOrFail($id);
        $cat->delete();
        return back()->with('success', 'Category deleted successfully.');
    }

    // ── Specifications CRUD ──────────────────────────────────────

    public function storeSpecification(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255|unique:specifications,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = $this->handleImageUpload($request, 'image');

        Specification::create([
            'name' => $fields['name'],
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Specification created successfully.');
    }

    public function updateSpecification(Request $request, $id)
    {
        $spec = Specification::findOrFail($id);
        $fields = $request->validate([
            'name' => 'required|string|max:255|unique:specifications,name,' . $spec->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $updateData = [
            'name' => $fields['name']
        ];

        $imagePath = $this->handleImageUpload($request, 'image');
        if ($imagePath) {
            $updateData['image'] = $imagePath;
        }

        $spec->update($updateData);

        return back()->with('success', 'Specification updated successfully.');
    }

    public function deleteSpecification($id)
    {
        $spec = Specification::findOrFail($id);
        $spec->delete();
        return back()->with('success', 'Specification deleted successfully.');
    }

    // ── Key Features CRUD ────────────────────────────────────────

    public function storeKeyFeature(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255|unique:key_features,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = $this->handleImageUpload($request, 'image');

        KeyFeature::create([
            'name' => $fields['name'],
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Key Feature created successfully.');
    }

    public function updateKeyFeature(Request $request, $id)
    {
        $feat = KeyFeature::findOrFail($id);
        $fields = $request->validate([
            'name' => 'required|string|max:255|unique:key_features,name,' . $feat->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $updateData = [
            'name' => $fields['name']
        ];

        $imagePath = $this->handleImageUpload($request, 'image');
        if ($imagePath) {
            $updateData['image'] = $imagePath;
        }

        $feat->update($updateData);

        return back()->with('success', 'Key Feature updated successfully.');
    }

    public function deleteKeyFeature($id)
    {
        $feat = KeyFeature::findOrFail($id);
        $feat->delete();
        return back()->with('success', 'Key Feature deleted successfully.');
    }

    // ── Amenities CRUD ───────────────────────────────────────────

    public function storeAmenity(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255|unique:amenities,name',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = $this->handleImageUpload($request, 'image');

        Amenity::create([
            'name' => $fields['name'],
            'icon' => $fields['icon'] ?? 'done',
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Amenity created successfully.');
    }

    public function updateAmenity(Request $request, $id)
    {
        $am = Amenity::findOrFail($id);
        $fields = $request->validate([
            'name' => 'required|string|max:255|unique:amenities,name,' . $am->id,
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $updateData = [
            'name' => $fields['name'],
            'icon' => $fields['icon'] ?? $am->icon,
        ];

        $imagePath = $this->handleImageUpload($request, 'image');
        if ($imagePath) {
            $updateData['image'] = $imagePath;
        }

        $am->update($updateData);

        return back()->with('success', 'Amenity updated successfully.');
    }

    public function deleteAmenity($id)
    {
        $am = Amenity::findOrFail($id);
        $am->delete();
        return back()->with('success', 'Amenity deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function approveParent($parentId)
{
    $parent = \App\Models\ParentModel::find($parentId);

    if ($parent) {
        $parent->is_approved = true; // Approve the parent
        $parent->save();

        return redirect()->back()->with('success', 'Parent approved successfully.');
    }

    return redirect()->back()->with('error', 'Parent not found.');
}

}

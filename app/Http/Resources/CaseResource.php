<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = Auth::user();
        $pricingUsers = User::query()->where('role', User::PRICING)->pluck('name', 'id');


        $response = array_merge([
             'id' => $this->id,
             'case_no' => $this->case_no,
             'brand' => $this->brand,
             'model' => $this->model,
             'year' => $this->year,
             'vin' => $this->vin,
             'created_by_name' => $this->createdBy->name,
             'assigned_to' => view('admin.case.datatable.assigned_to', ['case' => $this, 'pricingUsers' => $pricingUsers])->render(),
             'status' => view('admin.case.datatable.status', ['case' => $this])->render(),
             'action' => view('admin.case.datatable.action', ['case' => $this, 'user' => $user])->render(),
         ]);

        return $response;
    }
}

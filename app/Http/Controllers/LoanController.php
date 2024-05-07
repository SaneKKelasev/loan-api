<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LoanController extends Controller
{
    /**
     * Create a new loan.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1000|max:10000',
            'interest_rate' => 'required|numeric|min:0|max:100',
        ]);

        $loan = Loan::create($validatedData);

        return response()->json($loan, 201);
    }

    /**
     * Display the specified loan.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $loan = Loan::findOrFail($id);

        return response()->json($loan);
    }

    /**
     * Update the specified loan in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);

        $validatedData = $this->validate($request, [
            'user_id' => 'sometimes|required|exists:users,id',
            'amount' => 'sometimes|required|numeric|min:1000|max:10000',
            'interest_rate' => 'sometimes|required|numeric|min:0|max:100',
        ]);

        $loan->update($validatedData);

        return response()->json($loan);
    }

    /**
     * Remove the specified loan from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $loan = Loan::findOrFail($id);

        $loan->delete();

        return response()->json(null, 204);
    }

    /**
     * Get a listing of loans.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $query = Loan::query();

        if ($request->has('created_at')) {
            $query->whereDate('created_at', $request->input('created_at'));
        }

        if ($request->has('amount')) {
            $query->where('amount', $request->input('amount'));
        }

        $loans = $query->paginate(5);

        return response()->json($loans);
    }
}

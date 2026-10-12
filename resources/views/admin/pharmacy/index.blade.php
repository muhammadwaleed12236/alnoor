@extends('layouts.admin')

@section('title', 'Pharmacy Stock')
@section('page_title', 'Medical Store & Pharmacy Management')

@section('content')
  <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;">
    <!-- Add Medicine Card -->
    <div class="content-box">
      <div class="content-box-header">
        <h3><i class="fa-solid fa-pills" style="color: var(--primary);"></i> Add Medicine to Stock</h3>
      </div>

      <form action="{{ route('admin.pharmacy.store') }}" method="POST" class="quick-form">
        @csrf

        <div class="form-group">
          <label for="name">Medicine Trade Name *</label>
          <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Folic Acid 5mg" required>
        </div>

        <div class="form-group">
          <label for="generic_name">Generic / Formula Name</label>
          <input type="text" name="generic_name" id="generic_name" class="form-control" placeholder="e.g. Folate Supplement">
        </div>

        <div class="form-group">
          <label for="category">Category</label>
          <select name="category" id="category" class="form-control">
            <option value="Maternity">Maternity & Mother Care</option>
            <option value="Gynecology">Gynecology</option>
            <option value="Antibiotics">Antibiotics</option>
            <option value="Analgesic">Pain & Fever (Analgesic)</option>
            <option value="Emergency">Emergency Injections</option>
            <option value="General">General Medical</option>
          </select>
        </div>

        <div class="form-row-2col">
          <div class="form-group">
            <label for="stock_qty">Stock Units *</label>
            <input type="number" name="stock_qty" id="stock_qty" class="form-control" required placeholder="100" min="0">
          </div>
          <div class="form-group">
            <label for="unit_price">Unit Price (Rs.) *</label>
            <input type="number" name="unit_price" id="unit_price" class="form-control" required placeholder="150" min="0" step="0.5">
          </div>
        </div>

        <div class="form-group">
          <label for="expiry_date">Expiry Date</label>
          <input type="date" name="expiry_date" id="expiry_date" class="form-control" value="{{ date('Y-m-d', strtotime('+1 year')) }}">
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem;">
          <i class="fa-solid fa-plus"></i> Add to Inventory
        </button>
      </form>
    </div>

    <!-- Inventory Stock Table -->
    <div class="content-box">
      <div class="content-box-header">
        <div style="display: flex; gap: 0.5rem; align-items: center;">
          <h3><i class="fa-solid fa-boxes-stacked" style="color: #059669;"></i> In-Stock Inventory</h3>
          <span class="badge" style="background: #e0f2fe; color: #0284c7; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem;">
            Total: {{ $medicines->total() }}
          </span>
        </div>
      </div>

      <!-- Filter Form -->
      <form method="GET" action="{{ route('admin.pharmacy.index') }}" style="display: flex; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 1.25rem; background: #f8fafc; padding: 0.75rem; border-radius: 8px;">
        <input type="text" name="search" class="form-control" style="max-width: 240px;" placeholder="Search trade or generic name..." value="{{ request('search') }}">
        <select name="category" class="form-control" style="max-width: 180px;">
          <option value="">All Categories</option>
          <option value="Maternity" {{ request('category') == 'Maternity' ? 'selected' : '' }}>Maternity</option>
          <option value="Gynecology" {{ request('category') == 'Gynecology' ? 'selected' : '' }}>Gynecology</option>
          <option value="Antibiotics" {{ request('category') == 'Antibiotics' ? 'selected' : '' }}>Antibiotics</option>
          <option value="Emergency" {{ request('category') == 'Emergency' ? 'selected' : '' }}>Emergency</option>
        </select>
        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        <a href="{{ route('admin.pharmacy.index') }}" class="btn btn-outline btn-sm">Reset</a>
      </form>

      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Medicine</th>
              <th>Category</th>
              <th>Stock Qty</th>
              <th>Price</th>
              <th>Expiry</th>
              <th>Update Stock</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($medicines as $med)
              <tr>
                <td>
                  <strong>{{ $med->name }}</strong>
                  <div style="font-size: 0.72rem; color: var(--gray-500);">{{ $med->generic_name ?? '-' }}</div>
                </td>
                <td><span class="dept-tag">{{ $med->category }}</span></td>
                <td>
                  @if($med->stock_qty < 30)
                    <strong style="color: var(--danger);"><i class="fa-solid fa-triangle-exclamation"></i> {{ $med->stock_qty }}</strong>
                  @else
                    <strong style="color: #166534;">{{ $med->stock_qty }}</strong>
                  @endif
                </td>
                <td>Rs. {{ number_format($med->unit_price) }}</td>
                <td><span style="font-size: 0.8rem;">{{ $med->expiry_date ? date('M Y', strtotime($med->expiry_date)) : '-' }}</span></td>
                <td>
                  <form action="{{ route('admin.pharmacy.update', $med) }}" method="POST" style="display: flex; gap: 0.35rem; align-items: center;">
                    @csrf
                    @method('PUT')
                    <input type="number" name="stock_qty" value="{{ $med->stock_qty }}" class="form-control" style="width: 70px; padding: 2px 6px; font-size: 0.8rem;">
                    <input type="hidden" name="unit_price" value="{{ $med->unit_price }}">
                    <button type="submit" class="btn btn-sm btn-outline" style="padding: 2px 7px;" title="Update Stock">
                      <i class="fa-solid fa-check"></i>
                    </button>
                  </form>
                </td>
                <td>
                  <form action="{{ route('admin.pharmacy.destroy', $med) }}" method="POST" onsubmit="return confirm('Remove medicine?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="color: var(--danger); border: none; background: none; cursor: pointer;">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" style="text-align: center; color: var(--gray-500); padding: 1.5rem;">No medicines found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div style="margin-top: 1.25rem;">
        {{ $medicines->links() }}
      </div>
    </div>
  </div>
@endsection

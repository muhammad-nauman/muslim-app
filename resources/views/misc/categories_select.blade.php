<div class="form-group">
    <label>Category *</label>
    <select class="form-control m-b required" name="category_id">
        <option value="">Select Category</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}" @if(isset($selected) && $selected == $category->id) selected @endif)>{{ $category->name }}</option>
        @endforeach
    </select>
</div>
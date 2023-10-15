<form id="myForm" name="myForm"  enctype="multipart/form-data">
    @csrf
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">Tilte</span>
        <input type="text" name="title" id="title" class="form-control" value="{{old('title')}}" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
    </div>
    <p class="text-danger fw-bold mb-2 error-tag title d-none">Invalid Title</p>
    <span ></span>

    <div class="input-group mb-3">
        <span class="input-group-text">Description</span>
        <textarea class="form-control" id="description" name="description" aria-label="With textarea">{{old('description')}}</textarea><br>
    </div>

    <p class="text-danger fw-bold mb-2 description error-tag d-none ">Invalid Title</p>

    <div class="input-group mb-3">
        <label class="input-group-text" for="categoryOption">category</label>
        <select class="form-select" name="category" id="categoryOption">
          <option value="" >Choose...</option>
          @foreach ($categories as $category)
                <option value="{{$category->id}}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{$category->body}}</option>
          @endforeach>
        </select>
    </div>

    <p class="text-danger fw-bold mb-2 category error-tag d-none">Invalid Title</p>

    <div class="input-group mb-3">
        <label class="input-group-text" for="inputGroupFile01">Select File</label>
        <input type="file" name="image" class="form-control" id="inputGroupFile01">
    </div>
    @error('image')
        <span class="text-danger fw-bold">{{ $message }}</span>
    @enderror

     <div>
        <input type="submit" class="btn btn-primary" id="submit-report" value="{{$btnValue}}">
     </div>
</form>

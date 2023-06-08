
<form action="" method="get">
    <div class="search-input-group-style input-group mb-3">
        <div class="input-group-prepend">
            <button type="submit" style="padding: 0px; margin: 0px;" class="btn btn-primary">
                <span class="input-group-text" id="basic-addon1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
            </button>
        </div>
        <input type="text" name="search" id="search" class="form-control" placeholder="Search..."
        aria-label="Username" aria-describedby="basic-addon1" value="{{$search}}">
    </div>
</form>



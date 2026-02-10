<x-layout>
    <x-slot:title>Users</x-slot:title>
    <div class="card col-6 mx-auto">
        <div class="card-header">Search User</div>
        <div class="card-body text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form class="d-flex">
                            <div class="input-group">
                                <input class="form-control form-control-md" type="search"
                                    placeholder="Firstname/Lastname" aria-label="Search">
                                <button class="btn btn-primary px-4" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="card col-6 mt-3 mx-auto">
        <div class="card-header">Users</div>
        <div class="card-body">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
            <x-table :table_data="$table_data" />
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
</x-layout>
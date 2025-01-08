
 <section class="section-breadcrumb margin-b-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row bb-breadcrumb-inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="bb-breadcrumb-title">{{ getBreadcrumb()['title'] }}</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <ul class="bb-breadcrumb-list">
                                <li class="bb-breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li><i class="ri-arrow-right-double-fill"></i></li>
                                <li class="bb-breadcrumb-item active">{{ getBreadcrumb()['title'] }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
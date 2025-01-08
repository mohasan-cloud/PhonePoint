<div class="col-xl-3 col-md-4 col-6 mb-24 bb-product-box" data-aos="fade-up"
data-aos-duration="1000" data-aos-delay="200">
<div class="bb-pro-box">
    <div class="bb-pro-img">
        <span class="flags">
        </span>
        <a href="javascript:void(0)">
            <div class="inner-img">
                <img class="main-img" src="{{ asset('images/' . $product->image) }}"
                    alt="product-1">
                <img class="hover-img" src="{{ asset('images/' . $product->image) }}"
                    alt="product-1">
            </div>
        </a>
        <ul class="bb-pro-actions">
                <li class="bb-btn-group">
                    <a href="javascript:void(0)" class="heart-icon" data-product-id="{{ $product->id }}">
                        <i class="ri-heart-line"></i>
                    </a>
                </li>
            
            
        </ul>
    </div>
    <div class="bb-pro-contact">
        <div class="bb-pro-subtitle">
            <a href="{{route('Category.detail',$row->slug)}}">{{ $product->category }}</a>
            
            <span class="bb-pro-rating">

                @php
                // Get the number of stars (limit to a maximum of 5)
                $stars = min($product->extra_field_3, 5);
            @endphp

            <div>
                @for ($i = 0; $i < $stars; $i++)
                    <i class="ri-star-fill"></i>
                @endfor
            </div>
            </span>
        </div>
        <h4 class="bb-pro-title"><a href="{{route('product.detail',$product->slug)}}">{{ $product->title }}
               </a></h4>
        <div class="bb-price">
            <div class="inner-price">
                <span class="new-price">{{ $product->extra_field_5 }}{{ $product->extra_field_2 }}</span>
            </div>
        </div>
    </div>
</div>
</div>
<script>
export default {
    name: 'TrendingProducts',
    props: {
        homeCategory: {
            type: Array,
            required: true
        },
        showActiveClass: {
            type: Function,
            required: true
        },
        addToCart: {
            type: Function,
            required: false
        }
    },
    methods: {
        getShortCategoriesArray(size) {
            return this.homeCategory.slice(0, size);
        }
    }
}
</script>

<template>
    <section class="trending-product-area trending-product-two gray-bg pt-95 pb-100">
        <div class="container custom-container">
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-6">
                    <div class="section-title title-style-two text-center mb-50">
                        <h3 class="title">Trending Products</h3>
                    </div>
                </div>
            </div>
            <div class="row no-gutters trending-product-grid">
                <div class="col-2">
                    <div class="trending-products-list">
                        <h5>Category</h5>
                        <ul class="nav nav-tabs" id="trendingTab" role="tablist">
                            <li v-for="(catItem, index) in getShortCategoriesArray(6)" :key="catItem.id"
                                class="nav-item" role="presentation">
                                <a :class="'nav-link ' + showActiveClass(1, index)" :id="'cat-tab-' + catItem.id"
                                    data-toggle="tab" :href="'#cat-' + catItem.id" role="tab"
                                    :aria-controls="'cat-' + catItem.id"
                                    :aria-selected="index === 0 ? 'true' : 'false'">{{ catItem.name
                                    }}
                                </a>
                            </li>
                        </ul>
                        <p class="offer"><a href="#">Limited-Time Offer!</a></p>
                    </div>
                </div>
                <div class="col-10">
                    <div class="tab-content tp-tab-content" id="trendingTabContent">
                        <div v-for="(catItem, index) in getShortCategoriesArray(9)" :key="catItem.id"
                            :class="'tab-pane fade ' + showActiveClass(2, index)" :id="'cat-' + catItem.id"
                            role="tabpanel" :aria-labelledby="'cat-tab-' + catItem.id">
                            <div class="trending-products-banner banner-animation">
                                <a href="shop-sidebar.html"><img :src="catItem.image" alt="" /></a>
                            </div>
                            <div v-if="catItem.products.length > 0" class="row trending-product-active">
                                <div v-for="item in catItem.products" class="col">
                                    <div class="features-product-item">
                                        <div class="features-product-thumb">
                                            <div class="discount-tag">-20%</div>
                                            <a href="shop-details.html">
                                                <img :src="item.image" alt="" />
                                            </a>
                                            <div class="product-overlay-action">
                                                <ul>
                                                    <li>
                                                        <a href="cart.html"><i class="far fa-heart"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="shop-details.html"><i class="far fa-eye"></i></a>
                                                    </li>
                                                    <li
                                                        v-if="item.product_attributes && item.product_attributes.length > 0">
                                                        <a href="javascript:void(0)"><i class="fa fa-shopping-cart"
                                                                @click="addToCart(item.id, item.product_attributes[0].id, 1)"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="features-product-content">
                                            <div class="rating">
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <h5>
                                                <a href="shop-details.html">{{ item.name }}</a>
                                            </h5>
                                            <p class="price">$67.00</p>
                                            <div class="features-product-bottom">
                                                <ul>
                                                    <li class="color-option">
                                                        <span class="gray"></span>
                                                        <span class="cyan"></span>
                                                        <span class="orange"></span>
                                                    </li>
                                                    <li class="limited-time">
                                                        <a href="#">Limited-Time Offer!</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="features-product-cart">
                                            <a v-if="item.product_attributes && item.product_attributes.length > 0"
                                                href="javascript:void(0)"
                                                @click="addToCart(item.id, item.product_attributes[0].id, 1)">add to
                                                cart</a>
                                            <a v-else href="shop-details.html">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

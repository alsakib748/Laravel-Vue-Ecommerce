<script>
import Layout from "./Layout.vue";
import axios from "axios";
import { getUrlList } from "../provider.js";
import TrendingProducts from '../components/TrendingProducts.vue';
import HomeBanner from '../components/HomeBanner.vue';
import HomeCategories from '../components/HomeCategories.vue';
import HomeBrands from '../components/HomeBrands.vue';

export default {
    name: "Index",
    components: {
        Layout,
        TrendingProducts,
        HomeBanner,
        HomeCategories,
        HomeBrands,
    },
    data() {
        return {
            homeBanner: [],
            homeCategories: [],
            homeBrands: [],
        }
    },
    mounted() {
        this.getHomePageData();
        console.log("Index Vue Component Call");
    },
    methods: {
        getShortCategoriesArray(size) {
            return this.homeCategories.slice(0, size);
        },
        showActiveClass(type, index) {
            //    type == 1; cat
            //    type == 2; products
            if (type == 1 && index == 0) {
                return 'active';
            } else if (type == 2 && index == 0) {
                return 'show active';
            } else {
                return '';
            }
        },
        async getHomePageData() {
            let url = getUrlList().getHomeData;
            try {
                let data = await axios.get(url);
                console.log(data);
                if (data.status == 200 && data.data.data.data.banner.length > 0) {
                    this.homeBanner = data.data.data.data.banner;
                    this.homeCategories = data.data.data.data.categories;
                    this.homeBrands = data.data.data.data.brands;
                }
            }
            catch (error) {
                console.log("Error", error);
            }
        }
    }
};
</script>

<template>
    <Layout>
        <!-- main-area -->
        <template v-slot:content="slotProps">
            <!-- <main> -->

            <!-- slider-area -->
            <HomeBanner :Banner="homeBanner" />
            <!-- slider-area-end -->

            <!-- shoes-category-area -->
            <HomeCategories :homeCategory="getShortCategoriesArray(3)" />
            <!-- shoes-category-area-end -->

            <!-- trending-product-area -->
            <TrendingProducts :homeCategory="getShortCategoriesArray(9)" :showActiveClass="showActiveClass"
                :addToCart="slotProps.addToCart" />
            <!-- trending-product-area-end -->

            <!-- new-arrival-area -->
            <section class="new-arrival-area pt-95 pb-45">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-4 col-lg-6">
                            <div class="section-title title-style-two text-center mb-45">
                                <h3 class="title">New Arrival Collection</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="new-arrival-nav mb-35">
                                <button class="active" data-filter="*">Best Sellers</button>
                                <button class="" data-filter=".cat-one">New Products</button>
                                <button class="" data-filter=".cat-two">Sales Products</button>
                            </div>
                        </div>
                    </div>
                    <div class="row new-arrival-active">
                        <div class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer cat-two">
                            <div class="new-arrival-item text-center mb-50">
                                <div class="thumb mb-25">
                                    <a href="shop-details.html"><img
                                            src="../assets/img/product/shoes_arrival_product01.jpg" alt="" /></a>
                                    <div class="product-overlay-action">
                                        <ul>
                                            <li>
                                                <a href="cart.html"><i class="far fa-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="shop-details.html"><i class="far fa-eye"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="content">
                                    <h5><a href="shop-details.html">Athletes Shoes</a></h5>
                                    <span class="price">$37.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer cat-one">
                            <div class="new-arrival-item text-center mb-50">
                                <div class="thumb mb-25">
                                    <div class="discount-tag">- 20%</div>
                                    <a href="shop-details.html"><img
                                            src="../assets/img/product/shoes_arrival_product02.jpg" alt="" /></a>
                                    <div class="product-overlay-action">
                                        <ul>
                                            <li>
                                                <a href="cart.html"><i class="far fa-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="shop-details.html"><i class="far fa-eye"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="content">
                                    <h5><a href="shop-details.html">Mountain Shoes</a></h5>
                                    <span class="price">$25.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer cat-two cat-one">
                            <div class="new-arrival-item text-center mb-50">
                                <div class="thumb mb-25">
                                    <a href="shop-details.html"><img
                                            src="../assets/img/product/shoes_arrival_product03.jpg" alt="" /></a>
                                    <div class="product-overlay-action">
                                        <ul>
                                            <li>
                                                <a href="cart.html"><i class="far fa-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="shop-details.html"><i class="far fa-eye"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="content">
                                    <h5><a href="shop-details.html">Travelling Shoes</a></h5>
                                    <span class="price">$19.50</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer cat-two">
                            <div class="new-arrival-item text-center mb-50">
                                <div class="thumb mb-25">
                                    <div class="discount-tag new">New</div>
                                    <a href="shop-details.html"><img
                                            src="../assets/img/product/shoes_arrival_product04.jpg" alt="" /></a>
                                    <div class="product-overlay-action">
                                        <ul>
                                            <li>
                                                <a href="cart.html"><i class="far fa-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="shop-details.html"><i class="far fa-eye"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="content">
                                    <h5><a href="shop-details.html">Women Shoes</a></h5>
                                    <span class="price">$12.90</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer cat-one">
                            <div class="new-arrival-item text-center mb-50">
                                <div class="thumb mb-25">
                                    <div class="discount-tag">- 20%</div>
                                    <a href="shop-details.html"><img
                                            src="../assets/img/product/shoes_arrival_product05.jpg" alt="" /></a>
                                    <div class="product-overlay-action">
                                        <ul>
                                            <li>
                                                <a href="cart.html"><i class="far fa-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="shop-details.html"><i class="far fa-eye"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="content">
                                    <h5><a href="shop-details.html">Men Shoes</a></h5>
                                    <span class="price">$49.90</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer cat-two cat-one">
                            <div class="new-arrival-item text-center mb-50">
                                <div class="thumb mb-25">
                                    <div class="discount-tag new">New</div>
                                    <a href="shop-details.html"><img
                                            src="../assets/img/product/shoes_arrival_product06.jpg" alt="" /></a>
                                    <div class="product-overlay-action">
                                        <ul>
                                            <li>
                                                <a href="cart.html"><i class="far fa-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="shop-details.html"><i class="far fa-eye"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="content">
                                    <h5><a href="shop-details.html">Fashion Shoes</a></h5>
                                    <span class="price">$31.99</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer cat-one">
                            <div class="new-arrival-item text-center mb-50">
                                <div class="thumb mb-25">
                                    <a href="shop-details.html"><img
                                            src="../assets/img/product/shoes_arrival_product07.jpg" alt="" /></a>
                                    <div class="product-overlay-action">
                                        <ul>
                                            <li>
                                                <a href="cart.html"><i class="far fa-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="shop-details.html"><i class="far fa-eye"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="content">
                                    <h5><a href="shop-details.html">New Shoes</a></h5>
                                    <span class="price">$19.99</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-sm-6 grid-item grid-sizer cat-two">
                            <div class="new-arrival-item text-center mb-50">
                                <div class="thumb mb-25">
                                    <div class="discount-tag">- 45%</div>
                                    <a href="shop-details.html"><img
                                            src="../assets/img/product/shoes_arrival_product08.jpg" alt="" /></a>
                                    <div class="product-overlay-action">
                                        <ul>
                                            <li>
                                                <a href="cart.html"><i class="far fa-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="shop-details.html"><i class="far fa-eye"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="content">
                                    <h5><a href="shop-details.html">Travelling Bags</a></h5>
                                    <span class="price">$9.99</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- new-arrival-area-end -->

            <!-- shoes-banner-area -->
            <section class="shoes-banner-area">
                <div class="container">
                    <div class="shoes-banner-active">
                        <div class="shoes-banner-bg"
                            style="background-image:url('/front_assets/img/bg/shoes-banner_bg.jpg');">
                            <div class="row">
                                <div class="col-12">
                                    <div class="shoes-banner-content">
                                        <h6>Athletes Shoes</h6>
                                        <h2>
                                            9 Best <span>Shoes for</span> Standing All Day Review 2020
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="shoes-banner-bg"
                            style="background-image:url('/front_assets/img/bg/shoes-banner_bg.jpg');">
                            <div class="row">
                                <div class="col-12">
                                    <div class="shoes-banner-content">
                                        <h6>Athletes Shoes</h6>
                                        <h2>
                                            3 Best <span>Shoes for</span> Standing All Day Review 2021
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="shoes-banner-bg"
                            style="background-image:url('/front_assets/img/bg/shoes-banner_bg.jpg');">
                            <div class="row">
                                <div class="col-12">
                                    <div class="shoes-banner-content">
                                        <h6>Athletes Shoes</h6>
                                        <h2>
                                            8 Best <span>Shoes for</span> Standing All Day Review 2021
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- shoes-banner-area-end -->

            <!-- promo-services -->
            <section class="promo-services pt-70 pb-25">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 col-md-6 col-sm-8">
                            <div class="promo-services-item mb-40">
                                <div class="icon">
                                    <img src="../assets/img/icon/promo_icon01.png" alt="" />
                                </div>
                                <div class="content">
                                    <h6>payment & delivery</h6>
                                    <p>Delivered, when you receive arrives</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-8">
                            <div class="promo-services-item mb-40">
                                <div class="icon">
                                    <img src="../assets/img/icon/promo_icon02.png" alt="" />
                                </div>
                                <div class="content">
                                    <h6>Return Product</h6>
                                    <p>Retail, a Product Return Process</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-8">
                            <div class="promo-services-item mb-40">
                                <div class="icon">
                                    <img src="../assets/img/icon/promo_icon03.png" alt="" />
                                </div>
                                <div class="content">
                                    <h6>money back guarantee</h6>
                                    <p>Options Including 24/7</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-8">
                            <div class="promo-services-item mb-40">
                                <div class="icon">
                                    <img src="../assets/img/icon/promo_icon04.png" alt="" />
                                </div>
                                <div class="content">
                                    <h6>Quality support</h6>
                                    <p>Support Options Including 24/7</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- promo-services-end -->

            <!-- instagram-post-area -->
            <HomeBrands :homeBrands="homeBrands" />
            <!-- instagram-post-area-end -->

            <!-- </main> -->
        </template>
        <!-- main-area-end -->
    </Layout>
</template>

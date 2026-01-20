<script>

import Layout from './Layout.vue';
import axios from 'axios';
import { getUrlList } from '../provider.js';
import { useRoute } from 'vue-router';

export default {
    name: "Category",
    components: {
        Layout,
    },
    data() {
        return {
            categories: [],
            category: '',
            products: [],
            brands: [],
            colors: [],
            sizes: [],
            lowPrice: '',
            highPrice: '',
            slug: '',
            priceRange: '',
            brand: [],
            size: [],
            color: [],
            brandColor: 'brandColor',
            sizeColor: 'sizeColor',
            colorColor: 'colorColor',
        }
    },
    // watch work like onChange in js
    watch: {
        '$route'() {
            this.getProducts();
        }
    },
    mounted() {
        console.log('Index file call');
        this.getProducts();
    },
    methods: {

        addDataAttr(type, value) {
            if (type == 'brand') {
                // console.log(this.brand);
                if (this.checkArray(type, value)) {
                    // true value exist in array
                    this.brand.splice(this.brand.indexOf(value), 1);
                }
                else {
                    // false value not exist in array
                    this.brand.push(value);
                }
                console.log(this.brand);
            } else if (type == 'size') {
                // console.log(this.brand);
                if (this.checkArray(type, value)) {
                    // true value exist in array
                    this.size.splice(this.size.indexOf(value), 1);
                }
                else {
                    // false value not exist in array
                    this.size.push(value);
                }
                console.log(this.brand);
            } else if (type == 'color') {
                // console.log(this.brand);
                if (this.checkArray(type, value)) {
                    // true value exist in array
                    this.color.splice(this.color.indexOf(value), 1);
                }
                else {
                    // false value not exist in array
                    this.color.push(value);
                }
                console.log(this.color);
            }
        },

        checkArray(type, value) {

            if (type == 'brand') {
                return this.brand.includes(value);
            } else if (type == 'size') {
                return this.size.includes(value);
            } else if (type == 'color') {
                return this.color.includes(value);
            }

        },

        async getProducts() {
            try {

                const route = useRoute();

                // this.slug = route.params.slug;
                this.slug = this.$route.params.slug;

                // console.log(this.slug);

                if (this.slug == '' || this.slug == undefined || this.slug == null) {
                    this.$router.push({ name: 'Index' });
                } else {
                    let data = await axios.get(getUrlList().getCategoryData + '/' + this.slug);

                    console.log('Category Data', data);

                    if (data.status == 200 && data.data.data.data.products.data.length > 0) {
                        this.products = data.data.data.data.products.data;
                        this.categories = data.data.data.data.cat;
                        this.brands = data.data.data.data.brands;
                        this.colors = data.data.data.data.colors;
                        this.sizes = data.data.data.data.sizes;
                        this.lowPrice = data.data.data.data.lowPrice;
                        this.highPrice = data.data.data.data.highPrice;

                        this.catCount = 0;

                        // console.log('Products', this.products);
                    }
                }

            } catch (error) {
                console.log('Error', error);
            }
        },
        getImageUrl(image) {
            if (!image) return '/images/placeholder.jpg';
            // If image already contains full URL, return as is
            if (image.startsWith('http')) return image;
            // If image already starts with /, return as is
            if (image.startsWith('/')) return image;
            // Otherwise prepend /
            return '/' + image;
        }
    }
}

</script>

<template>
    <Layout>
        <template v-slot:content>

            <!-- main-area -->
            <!-- <main> -->
            <!-- breadcrumb-area -->
            <section class="breadcrumb-area breadcrumb-bg" data-background="/front_assets/img/bg/breadcrumb_bg01.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="breadcrumb-content">
                                <h2>Shop Sidebar</h2>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="index.html">Home</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Shop
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- breadcrumb-area-end -->

            <!-- shop-area -->
            <section class="shop-area pt-100 pb-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-9 col-lg-8">
                            <div class="shop-top-meta mb-35">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="shop-top-left">
                                            <ul>
                                                <li>
                                                    <a href="#"><i class="flaticon-menu"></i> FILTER</a>
                                                </li>
                                                <li>Showing 1–9 of 80 results</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="shop-top-right">
                                            <form action="#">
                                                <select name="select">
                                                    <option value="">Sort by newness</option>
                                                    <option>Free Shipping</option>
                                                    <option>Best Match</option>
                                                    <option>Newest Item</option>
                                                    <option>Size A - Z</option>
                                                </select>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div v-for="item in products" :key="item.id" class="col-xl-4 col-sm-6">
                                    <div class="new-arrival-item text-center mb-50">
                                        <div class="thumb mb-25">
                                            <!-- <a href="shop-details.html"><img :src="getImageUrl(item.image)"
                                                    alt="Product Image" /></a> -->
                                            <a href="shop-details.html"><img :src="'/' + item.image"
                                                    alt="Product Image" /></a>
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
                                            <!-- <h5><a href="shop-details.html">{{ item.name }}</a></h5> -->
                                            <h5><router-link :to="'/product/details/'">{{ item.name }}</router-link>
                                            </h5>
                                            <span class="price">$ {{ item.product_attributes[0].price }}</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-xl-4 col-sm-6">
                                    <div class="new-arrival-item text-center mb-50">
                                        <div class="thumb mb-25">
                                            <div class="discount-tag">- 20%</div>
                                            <a href="shop-details.html"><img src="img/product/n_arrival_product02.jpg"
                                                    alt="" /></a>
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
                                            <span class="price">$25.00</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                    <div class="new-arrival-item text-center mb-50">
                                        <div class="thumb mb-25">
                                            <a href="shop-details.html"><img src="img/product/n_arrival_product03.jpg"
                                                    alt="" /></a>
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
                                            <h5>
                                                <a href="shop-details.html">Exclusive Handbags</a>
                                            </h5>
                                            <span class="price">$19.50</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                    <div class="new-arrival-item text-center mb-50">
                                        <div class="thumb mb-25">
                                            <div class="discount-tag new">New</div>
                                            <a href="shop-details.html"><img src="img/product/n_arrival_product04.jpg"
                                                    alt="" /></a>
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
                                <div class="col-xl-4 col-sm-6">
                                    <div class="new-arrival-item text-center mb-50">
                                        <div class="thumb mb-25">
                                            <div class="discount-tag">- 20%</div>
                                            <a href="shop-details.html"><img src="img/product/n_arrival_product05.jpg"
                                                    alt="" /></a>
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
                                            <h5><a href="shop-details.html">Winter Jackets</a></h5>
                                            <span class="price">$49.90</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                    <div class="new-arrival-item text-center mb-50">
                                        <div class="thumb mb-25">
                                            <div class="discount-tag new">New</div>
                                            <a href="shop-details.html"><img src="img/product/n_arrival_product06.jpg"
                                                    alt="" /></a>
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
                                <div class="col-xl-4 col-sm-6">
                                    <div class="new-arrival-item text-center mb-50">
                                        <div class="thumb mb-25">
                                            <a href="shop-details.html"><img src="img/product/n_arrival_product07.jpg"
                                                    alt="" /></a>
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
                                            <h5><a href="shop-details.html">Winter Jackets</a></h5>
                                            <span class="price">$19.99</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                    <div class="new-arrival-item text-center mb-50">
                                        <div class="thumb mb-25">
                                            <div class="discount-tag">- 45%</div>
                                            <a href="shop-details.html"><img src="img/product/n_arrival_product08.jpg"
                                                    alt="" /></a>
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
                                <div class="col-xl-4 col-sm-6">
                                    <div class="new-arrival-item text-center mb-50">
                                        <div class="thumb mb-25">
                                            <div class="discount-tag new">New</div>
                                            <a href="shop-details.html"><img src="img/product/n_arrival_product09.jpg"
                                                    alt="" /></a>
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
                                            <span class="price">$31.99</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                    <div class="new-arrival-item text-center mb-50">
                                        <div class="thumb mb-25">
                                            <a href="shop-details.html"><img src="img/product/n_arrival_product10.jpg"
                                                    alt="" /></a>
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
                                            <h5><a href="shop-details.html">Winter Jackets</a></h5>
                                            <span class="price">$19.99</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                    <div class="new-arrival-item text-center mb-50">
                                        <div class="thumb mb-25">
                                            <a href="shop-details.html"><img src="img/product/n_arrival_product11.jpg"
                                                    alt="" /></a>
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
                                            <h5><a href="shop-details.html">Leather Sandal</a></h5>
                                            <span class="price">$9.99</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                    <div class="new-arrival-item text-center mb-50">
                                        <div class="thumb mb-25">
                                            <div class="discount-tag">- 45%</div>
                                            <a href="shop-details.html"><img src="img/product/n_arrival_product12.jpg"
                                                    alt="" /></a>
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
                                            <h5>
                                                <a href="shop-details.html">Double Relaxed Shirt</a>
                                            </h5>
                                            <span class="price">$9.99</span>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="pagination-wrap">
                                <ul>
                                    <li class="prev"><a href="#">Prev</a></li>
                                    <li><a href="#">1</a></li>
                                    <li class="active"><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#">...</a></li>
                                    <li><a href="#">10</a></li>
                                    <li class="next"><a href="#">Next</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4">
                            <aside class="shop-sidebar">
                                <div class="widget side-search-bar">
                                    <form action="#">
                                        <input type="text" />
                                        <button><i class="flaticon-search"></i></button>
                                    </form>
                                </div>
                                <div class="widget">
                                    <h4 class="widget-title">Product Categories</h4>
                                    <div class="shop-cat-list">
                                        <ul>
                                            <li v-for="item in categories" :key="item.id">
                                                <!-- <a href="#">Accessories</a><span>(6)</span> -->
                                                <router-link :to="'/category/' + item.slug">{{ item.name
                                                }}</router-link>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="widget">
                                    <h4 class="widget-title">Price Filter</h4>
                                    <div class="price_filter">
                                        <div id="slider-range"></div>
                                        <div class="price_slider_amount">
                                            <span>Price :</span>
                                            <input type="text" id="amount" v-model="priceRange"
                                                placeholder="Add Your Price" />
                                        </div>
                                    </div>
                                </div>
                                <div class="widget">
                                    <h4 class="widget-title">Product Brand</h4>
                                    <div class="sidebar-brand-list">
                                        <ul>
                                            <li v-for="item in brands" :key="item.id"
                                                v-on:click="addDataAttr('brand', item.id)"
                                                :class="this.brand.includes(item.id) ? brandColor : ''">
                                                <a href="javascript:void(0)">{{ item.name }} <i
                                                        class="fas fa-angle-double-right"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="widget has-border">
                                    <div class="sidebar-product-size mb-30">
                                        <h4 class="widget-title">Product Size</h4>
                                        <div class="shop-size-list">
                                            <ul>
                                                <li v-for="item in sizes" :key="item.id"
                                                    v-on:click="addDataAttr('size', item.id)"
                                                    :class="this.size.includes(item.id) ? sizeColor : ''"><a
                                                        href="javascript:void(0)">{{
                                                            item.size }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="sidebar-product-color">
                                        <h4 class="widget-title">Color</h4>
                                        <div class="shop-color-list">
                                            <ul>
                                                <li v-for="item in colors" :key="item.id"
                                                    :style="{ backgroundColor: item.value }"
                                                    v-on:click="addDataAttr('color', item.id)"
                                                    :class="this.color.includes(item.id) ? colorColor : ''"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="cart-coupon">
                                        <form action="">
                                            <button type="submit" class="btn">Filter</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="widget">
                                    <h4 class="widget-title">Top Items</h4>
                                    <div class="sidebar-product-list">
                                        <ul>
                                            <li>
                                                <div class="sidebar-product-thumb">
                                                    <a href="#"><img src="img/product/sidebar_product01.jpg"
                                                            alt="" /></a>
                                                </div>
                                                <div class="sidebar-product-content">
                                                    <div class="rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                    <h5><a href="#">Woman T-shirt</a></h5>
                                                    <span>$ 39.00</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="sidebar-product-thumb">
                                                    <a href="#"><img src="img/product/sidebar_product02.jpg"
                                                            alt="" /></a>
                                                </div>
                                                <div class="sidebar-product-content">
                                                    <div class="rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                    <h5><a href="#">Slim Fit Cotton</a></h5>
                                                    <span>$ 39.00</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="sidebar-product-thumb">
                                                    <a href="#"><img src="img/product/sidebar_product03.jpg"
                                                            alt="" /></a>
                                                </div>
                                                <div class="sidebar-product-content">
                                                    <div class="rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                    <h5><a href="#">Fashion T-shirt</a></h5>
                                                    <span>$ 39.00</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="highPrice" v-model="highPrice" />

                <input type="hidden" id="lowPrice" v-model="lowPrice" />

            </section>
            <!-- shop-area-end -->
            <!-- </main> -->
            <!-- main-area-end -->

        </template>
    </Layout>
</template>

<style scoped>
.brandColor::before {
    background-color: #ff5400;
}

.sizeColor {
    background-color: #ff5400;
    color: #fff;
}

.colorColor::before {
    content: '\2713';
    display: flex;
    justify-content: center;
    align-items: center;
    height: 25px;
    width: 30px;
    font-size: 25px;
    font-weight: bold;
    /* color: #2EC831; */
    color: #ddd;
    padding: 0 10px 11px 0;
}
</style>

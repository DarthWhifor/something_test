// @/pages/index.js
import React, {useEffect, useState} from 'react'
import Layout from '../components/Layout'
import axios from 'axios';
import Sidebar from '../components/Layout' ;
import { useRouter } from 'next/router'
import Link from "next/link";
import slugify from "slugify";


export default function CategoryPage() {
    const router = useRouter();
    const [newProducts, setNewProducts] = useState([]);
    useEffect(() => {
        const categoryProducts = async() => {
            const slugify = require('slugify');
            const data = router.query;
            const ourRequest = axios.CancelToken.source()
            const products = await axios.get('http://127.0.0.1:8000/api/' + data.category + '/products', { cancelToken: ourRequest.token,})
                .then(response =>

                    {
                        //console.log(response.data);
                        setNewProducts(response.data.products);
                        //ourRequest.cancel();
                    }
                )
                .catch(error => console.error(error));
        }
        categoryProducts();
    }, []);

    return (
        <Layout>
            <div className="p-4 sm:ml-64 grid grid-cols-4 gap-4">
                <div className="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                    <div className="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
                        {
                            newProducts.length >= 1 ? newProducts.map((product, idx) => {
                                return  <div key={idx}  className="ml-5" style={{marginLeft: 1 + "vw", marginTop:1 + "vh"}}>
                                    <img  className="w-10 h-10" src={"http://127.0.0.1:8000/storage/" + product.mainPhoto} style={{width: 20 + 'vw', height: 10 + "vw"}} />
                                    <p  className="text-2xl text-gray-400 dark:text-gray-500" style={{marginTop: 1 + "vh", textTransform: "upperCase", fontWeight: 800}}>
                                        {product.title}
                                    </p>
                                    <p  className="text-2xl text-gray-400 dark:text-gray-500" style={{marginTop: 1 + "vh"}}>
                                        {product.description}
                                    </p>
                                    <p  className="text-2xl text-gray-400 dark:text-gray-500" style={{marginTop: 1 + "vh"}}>
                                        {product.price}
                                    </p>
                                    <Link href={{
                                        pathname: "/product",
                                        query: {id: product.id, slug: product.categorySlug}
                                    }} as = {slugify(product.categoryTitle).toLowerCase() + '/' + slugify(product.title).toLowerCase() }>
                                        Comment
                                    </Link>
                                </div>
                            }) : ''
                        }
                    </div>
                </div>
            </div>
        </Layout>
    )
}

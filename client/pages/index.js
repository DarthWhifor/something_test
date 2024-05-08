// @/pages/index.js
import React, {useState} from 'react'
import Layout from '../components/Layout'
import axios from 'axios';
import Sidebar from '../components/Layout' ;
import { useRouter } from 'next/router'
import Link from "next/link";

export default function HomePage() {
    const router = useRouter();
    const [newState, setNewState] = useState([])
    const products = () => {
        axios.get('http://127.0.0.1:8000/api/all-products')
            .then(response =>
                //console.log(response.data.products)
                setNewState(response.data.products)
            )
            .catch(error => console.error(error));
    }
    products();
    return (
        <Layout>
            <div className="p-4 sm:ml-64 grid grid-cols-4 gap-4">
                <div className="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                    <div className="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
                        {
                            newState.length >= 1 ? newState.map((product, idx) => {
                                return  <div key={idx} id={product.id} className="ml-5" style={{marginLeft: 1 + "vw", marginTop:1 + "vh"}}>
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
                                                query: {id:"/"+product.id}
                                            }}>
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

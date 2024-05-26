// @/pages/index.js
import React, {useEffect, useState} from 'react'
import Layout from '../components/Layout'
import axios from 'axios';
import Sidebar from '../components/Layout' ;
import { useRouter } from 'next/router'
import Link from "next/link";


export default function CategoryPage() {
    const router = useRouter();
    const [newProducts, setNewProducts] = useState([])

    useEffect(() => {
        const categoryProducts = () => {
            const data = router.query;
            const ourRequest = axios.CancelToken.source()
            const products = axios.get('http://127.0.0.1:8000/api/product/' + data.id, { cancelToken: ourRequest.token,})
                .then(response =>
                    {
                        //console.log(response.data.product)
                        setNewProducts(response.data.product);
                        //ourRequest.cancel();
                    }
                )
                .catch(error => console.error(error));
        }
        categoryProducts();
    } , []);

    // POST
    const [comment, setComment] = useState('')
    const [rating, setRating] = useState('')
    const submitData = () => {
        const url = 'http://127.0.0.1:8000/api/new-comment';
        const headers = {
            'Content-Type': 'application/json',
        }
        const data = {
            comment_text: comment,
            rating: rating,
            product_id: newProducts['id'],
        };
        axios.post(url, data, { headers })
            .then(response => console.log(response.data))
            .catch(error => console.error('Error:', error));

    }

    return (
        <Layout>
            <div className="p-4 sm:ml-64 grid grid-cols-4 gap-4">
                <div className="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                    <div className="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
                        {
                            <div className="ml-5" style={{marginLeft: 1 + "vw", marginTop:1 + "vh"}}>
                                <img  className="w-10 h-10" src={"http://127.0.0.1:8000/storage/" + newProducts['mainPhoto']} style={{width: 20 + 'vw', height: 20 + "vw"}} />
                                <p  className="text-2xl text-gray-400 dark:text-gray-500" style={{marginTop: 1 + "vh", textTransform: "upperCase", fontWeight: 800}}>
                                    {newProducts['title']}
                                </p>
                                <p  className="text-2xl text-gray-400 dark:text-gray-500" style={{marginTop: 1 + "vh"}}>
                                    {newProducts['description']}
                                </p>
                                <p  className="text-2xl text-gray-400 dark:text-gray-500" style={{marginTop: 1 + "vh"}}>
                                    {newProducts['price']}
                                </p>
                            </div>
                        }

                        <div id="form" className="" style={{ marginTop: 5 + "vh" }}>
                            <input type="text"  className="form-control"
                                       style={{ border: 1 + "px solid black" }}
                                       placeholder="comment" value={comment}
                                       onChange={(e) => setComment(e.target.value)}
                            />

                            <select  className="bg-white  mt-1 border rounded-lg lg:w-1/2 mb-10 h-2"
                                     value={rating} onChange={(e) => setRating(e.target.value)}>
                                <option></option>
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                            </select>

                            <button  className="ml-5" type="submit" onClick={submitData} style={{ marginLeft: 1 + "vw" }}>SUBMIT COMMENT</button>
                        </div>

                    </div>
                </div>
            </div>
        </Layout>
    )
}

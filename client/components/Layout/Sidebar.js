// @/components/Layout/Sidebar.js
import React, { useState, useEffect } from 'react'
import Link from 'next/link'
import { useRouter } from 'next/router'

import { SlHome } from 'react-icons/sl'
import { BsInfoSquare, BsEnvelopeAt } from 'react-icons/bs'
import { FaTshirt, FaRedhat } from 'react-icons/fa'

import logo from '../../img/logo.svg'
import axios from "axios";
import {abortTask} from "next/dist/client/components/router-reducer/ppr-navigations";
import { useParams } from 'next/navigation'


export default function Sidebar({ show, setter }) {
    const router = useRouter();

    // Define our base class
    const className = "bg-black w-[250px] transition-[margin-left] ease-in-out duration-500 fixed md:static top-0 bottom-0 left-0 z-40";
    // Append class based on state of sidebar visiblity
    const appendClass = show ? " ml-0" : " ml-[-250px] md:ml-0";

    // Clickable menu items
    const MenuItem = ({ icon, name, route, data }) => {
        const slugify = require('slugify');
        const slugName = slugify(name);
        // Highlight menu item based on currently displayed route
        const colorClass =  router.query.slug === data.slug ? "text-white" : "text-white/50 hover:text-white";

        return (
            <Link key={data.category}
                href={{
                    pathname: route,
                    query: data // the data
                }} as = {slugName.toLowerCase()}
                className={`flex gap-1 [&>*]:my-auto text-md pl-6 py-3 border-b-[1px] border-b-white/10 ${colorClass}`}
            >
                <div className="text-xl flex [&>*]:mx-auto w-[30px]">
                    {icon}
                </div>
                <div>{name}</div>
            </Link>
        )
    }

    const [newState, setNewState] = useState([])
    useEffect(() => {
        const categories = async () => {
            const ourRequest = axios.CancelToken.source();
            await axios.get('http://127.0.0.1:8000/api/categories', { cancelToken: ourRequest.token,})
                .then(response =>
                    {
                        //console.log(response.data.categories);
                        setNewState(response.data.categories);
                        //ourRequest.cancel();
                    }
                )
                .catch(error => console.error(error));
        }
        categories();
    }, []);


    return (
        <>
            <div className={`${className}${appendClass}`}>
                <div className="flex flex-col">
                    <MenuItem
                        name={'All categories'}
                        route={'/'}
                        icon={<FaTshirt />}
                        data={{category: '', name: '', slug: ''}}/>
                    {
                        newState.length >= 1 ? newState.map((category, idx) => {
                            return <MenuItem key={idx}
                                name={category.title}
                                route={'/category'} as = {'/category'}
                                icon={<FaTshirt />}
                                data={{category: category.id, name: category.title, slug: category.categorySlug}}
                            />
                        }) : ''
                    }
                </div>
            </div>
        </>
    )
}



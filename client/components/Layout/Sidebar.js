// @/components/Layout/Sidebar.js
import React, { useState, useEffect } from 'react'
import Link from 'next/link'
import { useRouter } from 'next/router'

import { SlHome } from 'react-icons/sl'
import { BsInfoSquare, BsEnvelopeAt } from 'react-icons/bs'
import { FaTshirt, FaRedhat } from 'react-icons/fa'

import logo from '../../img/logo.svg'
import axios from "axios";


export default function Sidebar({ show, setter }) {
    const router = useRouter();

    // Define our base class
    const className = "bg-black w-[250px] transition-[margin-left] ease-in-out duration-500 fixed md:static top-0 bottom-0 left-0 z-40";
    // Append class based on state of sidebar visiblity
    const appendClass = show ? " ml-0" : " ml-[-250px] md:ml-0";

    // Clickable menu items
    const MenuItem = ({ icon, name, route, data }) => {
        // Highlight menu item based on currently displayed route
        const colorClass = router.pathname === route ? "text-white" : "text-white/50 hover:text-white";

        return (
            <Link
                href={{
                    pathname: route,
                    query: data // the data
                }} as = {route}
                className={`flex gap-1 [&>*]:my-auto text-md pl-6 py-3 border-b-[1px] border-b-white/10 ${colorClass}`}
            >
                <div className="text-xl flex [&>*]:mx-auto w-[30px]">
                    {icon}
                </div>
                <div>{name}</div>
            </Link>
        )
    }

    // Overlay to prevent clicks in background, also serves as our close button
    const ModalOverlay = () => (
        <div
            className={`flex md:hidden fixed top-0 right-0 bottom-0 left-0 bg-black/50 z-30`}
            onClick={() => {
                setter(oldVal => !oldVal);
            }}
        />
    )
    const [newState, setNewState] = useState([])
    const categories = () => {
        axios.get('http://127.0.0.1:8000/api/categories')
            .then(response =>
                //console.log(response.data.categories);
                setNewState(response.data.categories)
            )
            .catch(error => console.error(error));
    }
    categories();

    return (
        <>
            <div className={`${className}${appendClass}`}>
                <div className="flex flex-col">
                    {
                        newState.length >= 1 ? newState.map((category, idx) => {
                            return <MenuItem key={idx}
                                name={category.title}
                                route={ "/category" }
                                icon={<FaTshirt />}
                                data={{category: category.id}}
                            />
                        }) : ''
                    }
                </div>
            </div>
            {show ? <ModalOverlay /> : <></>}
        </>
    )
}



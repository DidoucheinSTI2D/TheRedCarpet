import React from "react";
import { Outlet } from "react-router-dom";
import TrcLogo from "../assets/TrcLogo.svg";

export default function AuthLayout() {
    return (
        <div className="flex justify-center w-screen h-screen pt-[15vh] m-auto">
            Test
            <Outlet />
        </div>
    );
}

import React from "react";
import { Outlet } from "react-router-dom";
import TrcLogo from "../assets/TrcLogo.svg";
import { LbFade } from "../components/animation/TrcFade";

export default function AuthLayout() {
  return (
    <div className="flex h-screen">
      <div className="flex w-[65vw] pl-[12vw] pt-[20vh] bg-[linear-gradient(132.96deg,#280B0B,#080808,#000000,#080808,#280B0B)]">
        <div className="flex flex-col gap-[44px] h-fit max-w-[518px]">
          <a href="/">
            <img className="w-44" src={TrcLogo} alt="The Red Carpet Logo" />
          </a>
          <h1 className="text-[52px] font-semibold leading-[54.73px] text-[#FFFFFF] tracking-[-0.02em] w-full">
            First step to your next advanture.
          </h1>
        </div>
      </div>
      <LbFade>
        <div className="flex justify-center items-center w-[35vw] h-screen m-auto">
          <Outlet />
        </div>
      </LbFade>
    </div>
  );
}

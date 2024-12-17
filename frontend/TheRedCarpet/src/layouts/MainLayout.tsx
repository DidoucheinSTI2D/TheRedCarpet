import React, { useMemo } from "react";
import { Outlet, Link, useNavigate } from "react-router-dom";
import { useAuth } from "../context/AuthContext";
import TrcLogo from "../assets/TrcLogo.svg";
import { Avatar, AvatarFallback, AvatarImage } from "../components/ui/avatar";
import { Button } from "../components/ui/button";
import { createAvatar } from "@dicebear/core";
import { avataaars } from "@dicebear/collection";

export default function MainLayout() {
  const { user } = useAuth();
  const navigate = useNavigate();

  const avatarUrl = useMemo(() => {
    if (user?.username) {
      const avatar = createAvatar(avataaars, {
        seed: user.username,
        backgroundColor: ["b6e3f4", "c0aede", "d1d4f9"],
        radius: 50,
      });

      return avatar.toDataUri();
    }

    return undefined;
  }, [user?.username]);

  return (
    <div className="min-h-screen bg-zinc-950">
      <header className="flex items-center justify-between pt-4 pb-3 pl-6 pr-6 sticky top-0 z-50 w-full bg-zinc-950/95 backdrop-blur supports-[backdrop-filter]:bg-zinc-950/60 border-b border-zinc-800">
        <Link to="/home" className="flex items-center gap-2">
          <img src={TrcLogo} alt="TRC Logo" className="h-14 w-auto" />
        </Link>

        <div className="flex items-center justify-end space-x-2">
          <Button
            variant="ghost"
            onClick={() => navigate("/finder")}
            className="text-base font-semibold text-zinc-200 hover:text-zinc-100 underline hover:underline-zinc-100 hover:bg-transparent"
          >
            Magic Finder
          </Button>

          <Avatar
            onClick={() => navigate("/profile")}
            className="h-10 w-10 cursor-pointer ring-2 ring-zinc-800 hover:ring-zinc-700"
          >
            <AvatarImage src={avatarUrl} alt={user?.username || "User"} />
            <AvatarFallback className="bg-zinc-800 text-zinc-200">
              {user?.username?.[0]?.toUpperCase() || "U"}
            </AvatarFallback>
          </Avatar>
        </div>
      </header>

      <main className="container pt-6 text-zinc-200">
        <Outlet />
      </main>
    </div>
  );
}

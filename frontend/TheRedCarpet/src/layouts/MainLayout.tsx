import React, { useMemo, useState } from "react";
import { Outlet, Link, useNavigate } from "react-router-dom";
import { useAuth } from "../context/AuthContext";
import TrcLogo from "../assets/TrcLogo.svg";
import { Avatar, AvatarFallback, AvatarImage } from "../components/ui/avatar";
import { Button } from "../components/ui/button";
import { createAvatar } from "@dicebear/core";
import { avataaars } from "@dicebear/collection";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "../components/ui/dropdown-menu";
import {
  Sheet,
  SheetContent,
  SheetDescription,
  SheetHeader,
  SheetTitle,
} from "../components/ui/sheet";
import { Input } from "../components/ui/input";
import { Label } from "../components/ui/label";
import { disconnectUser, updateUser } from "../api/API";

export default function MainLayout() {
  const { user, setUser } = useAuth();
  const navigate = useNavigate();
  const [isSheetOpen, setIsSheetOpen] = useState(false);
  const [formData, setFormData] = useState({
    username: user?.username || "",
    email: user?.email || "",
    birthdate: user?.birthdate || "",
  });

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

  const handleDisconnect = async () => {
    setUser(null);
    navigate("/");
  };

  const handleUpdateProfile = async () => {
    if (!user?.id) return;

    const result = await updateUser(
      user.id.toString(),
      formData.username,
      formData.email,
      formData.birthdate
    );

    if (!result.error) {
      setUser({
        ...user,
        username: formData.username,
        email: formData.email,
        birthdate: formData.birthdate,
      });
      setIsSheetOpen(false);
    }
  };

  return (
    <div className="min-h-screen bg-zinc-950">
      <header className="flex items-center justify-between pt-4 pb-3 pl-6 pr-6 sticky top-0 z-50 w-full bg-zinc-950/95 backdrop-blur supports-[backdrop-filter]:bg-zinc-950/60 border-b border-zinc-800">
        <Link to="/home" className="flex items-center gap-2">
          <img src={TrcLogo} alt="TRC Logo" className="h-14 w-auto" />
        </Link>

        <div className="flex items-center justify-end space-x-2">
          <DropdownMenu>
            <DropdownMenuTrigger asChild>
              <Avatar className="h-10 w-10 cursor-pointer ring-2 ring-zinc-800 hover:ring-zinc-700">
                <AvatarImage src={avatarUrl} alt={user?.username || "User"} />
                <AvatarFallback className="bg-zinc-800 text-zinc-200">
                  {user?.username?.[0]?.toUpperCase() || "U"}
                </AvatarFallback>
              </Avatar>
            </DropdownMenuTrigger>
            <DropdownMenuContent className="w-48">
              <DropdownMenuItem onClick={() => setIsSheetOpen(true)}>
                Edit Profile
              </DropdownMenuItem>
              <DropdownMenuItem onClick={handleDisconnect}>
                Disconnect
              </DropdownMenuItem>
            </DropdownMenuContent>
          </DropdownMenu>
        </div>
      </header>

      <Sheet open={isSheetOpen} onOpenChange={setIsSheetOpen}>
        <SheetContent>
          <SheetHeader>
            <SheetTitle>Edit Profile</SheetTitle>
            <SheetDescription>
              Make changes to your profile here. Click save when you're done.
            </SheetDescription>
          </SheetHeader>
          <div className="grid gap-4 py-4">
            <div className="grid grid-cols-4 items-center gap-4">
              <Label htmlFor="username" className="text-right">
                Username
              </Label>
              <Input
                id="username"
                value={formData.username}
                onChange={(e) =>
                  setFormData({ ...formData, username: e.target.value })
                }
                className="col-span-3"
              />
            </div>
            <div className="grid grid-cols-4 items-center gap-4">
              <Label htmlFor="email" className="text-right">
                Email
              </Label>
              <Input
                id="email"
                type="email"
                value={formData.email}
                onChange={(e) =>
                  setFormData({ ...formData, email: e.target.value })
                }
                className="col-span-3"
              />
            </div>
            <div className="grid grid-cols-4 items-center gap-4">
              <Label htmlFor="birthdate" className="text-right">
                Birthdate
              </Label>
              <Input
                id="birthdate"
                type="date"
                value={formData.birthdate}
                onChange={(e) =>
                  setFormData({ ...formData, birthdate: e.target.value })
                }
                className="col-span-3"
              />
            </div>
          </div>
          <div className="flex justify-end space-x-2 mt-4">
            <Button variant="outline" onClick={() => setIsSheetOpen(false)}>
              Cancel
            </Button>
            <Button onClick={handleUpdateProfile}>Save changes</Button>
          </div>
        </SheetContent>
      </Sheet>

      <main className="pt-6 text-zinc-200 flex flex-col items-center justify-center w-full">
        <Outlet />
      </main>
    </div>
  );
}

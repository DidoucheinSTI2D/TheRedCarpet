import React from "react";
import { useAuth } from "../../context/AuthContext";
import { LbFade } from "../animation/TrcFade";

export default function Profile() {
  const { user } = useAuth();

  if (!user) {
    return <div>Loading...</div>;
  }

  return (
    <LbFade>
      <div className="p-8">
        <h1 className="text-2xl font-bold mb-6">Personal Data.</h1>
        <div className="space-y-4">
          <div>
            <label className="font-semibold">Username:</label>
            <p>{user.username}</p>
          </div>
          <div>
            <label className="font-semibold">Email:</label>
            <p>{user.email}</p>
          </div>
          <div>
            <label className="font-semibold">Birthday:</label>
            <p>{user.birthdate}</p>
          </div>
        </div>
      </div>
    </LbFade>
  );
}

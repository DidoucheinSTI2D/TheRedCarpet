import React, { useEffect, useRef, useState } from "react";
import TopPost from "../TopPost/TopPost";
import BottomPost from "../BottomPost/BottomPost";

const Post = ({ data, position }: { data: any; position: number }) => {
  return (
    <div
      id={position.toString()}
      className="flex flex-col text-white w-[60rem] rounded-lg border border-gray-200 p-[1rem] hover:shadow-[0_0px_60px_-20px_rgba(255,0,0,0.8)]"
    >
      <TopPost name={data.name}></TopPost>
      <BottomPost
        likes={data.likes}
        description={data.description}
      ></BottomPost>
    </div>
  );
};

export default Post;

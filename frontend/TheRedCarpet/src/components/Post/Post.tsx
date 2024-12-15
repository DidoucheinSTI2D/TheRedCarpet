import React, { useEffect, useRef, useState } from 'react';
import TopPost from '../TopPost/TopPost'
import BottomPost from '../BottomPost/BottomPost'


const Post = ( { data, position  } ) => {
    return (
        <div
            id={position}    
            className="flex flex-col w-[80rem] h-[20rem] bg-white rounded-lg shadow-xl border border-gray-200 p-[1rem]"
        > 
            <TopPost name={data.name}></TopPost>
            <BottomPost likes={data.likes} description={data.description}></BottomPost>
        </div>
    );
};

export default Post;
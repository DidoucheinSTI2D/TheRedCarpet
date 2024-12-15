import React, { useState } from 'react';
import "./BottomPost.css"
import Like from "../../assets/Like.svg"
import Comment from "../../assets/Comment.svg"



const Test = ({likes, description}) => {

    const maxLength = 20;

    const [isExpanded, setIsExpanded] = useState(false);

    const isTruncatable = description.length > maxLength;

    const toggleExpand = () => {
        setIsExpanded(!isExpanded);
    };

    const displayedText = isExpanded || !isTruncatable ? description : description.slice(0, maxLength);


    return (
        <div className="flex flex-col gap-[1rem] justify-between"> 
            <div className='flex'>
                <div className='flex gap-[1rem]'>
                    <button className='flex justify-center items-center size-[3rem] border-2 rounded-full border-black'><img src={Like} alt="like" className=' size-[3rem]'/></button>
                    <button className='flex justify-center items-center size-[3rem] border-2 rounded-full border-black'><img src={Comment} alt="comment" className=' size-[2rem] '/></button>
                </div>
            </div>
            <div className='flex'>
                {likes} {(likes>1)?"Likes":"Like"}
            </div>
            <div className='flex items-center justify-start  gap-[1rem]'>
                <p className="transition-all duration-300">
                {displayedText}
                {!isExpanded && isTruncatable && '...'}
                </p>
                {isTruncatable && (
                    <button
                    onClick={toggleExpand}
                    className="text-black-500 underline"
                    >
                    {isExpanded ? 'See less' : 'See more'}
                    </button>
                )}
            </div>
            <button className='flex hover:underline'>See comments</button>
        </div>
    );
};

export default Test;
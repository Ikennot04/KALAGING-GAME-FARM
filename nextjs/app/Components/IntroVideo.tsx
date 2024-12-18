'use client'

import { useState, useRef, useEffect } from 'react';

const IntroVideo = () => {
  const [showVideo, setShowVideo] = useState(true);
  const videoRef = useRef<HTMLVideoElement>(null);

  useEffect(() => {
    if (videoRef.current) {
      videoRef.current.playbackRate = 0.0625; // Minimum supported playback rate in most browsers
    }
  }, []);

  if (!showVideo) return null;

  return (
    <div className="fixed inset-0 w-full h-full z-50 bg-black">
      <video
        ref={videoRef}
        className="w-full h-full object-cover"
        autoPlay
        muted
        onEnded={() => setShowVideo(false)}
      >
        <source src="/105226-669669053_small.mp4" type="video/mp4" />
      </video>
    </div>
  );
};

export default IntroVideo;